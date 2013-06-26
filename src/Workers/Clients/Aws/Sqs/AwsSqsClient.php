<?php
namespace Sansa\Workers\Clients\Aws\Sqs;

use Sansa\Events\MessagesEvent;
use Sansa\Workers\Clients\BaseClient;
use Aws\Sqs\SqsClient;

/**
* SQS Client
*/
class AwsSqsClient extends BaseClient
{
	private $client = null;
	private $notDelete = false;
	function __construct($config, $notDelete = false)
	{
		parent::__construct($config);

		$this->notDelete = $notDelete;

		$this->client = SqsClient::factory($config['SQS']['init']);
	}

	public function setEventDispatcher($dispatcher)
	{
		parent::setEventDispatcher($dispatcher);

		$this->getEventDispatcher()->addListener('messages:invalid', array($this, 'deleteMessages'));
	}

	protected function doReceiveMessages()
	{
		$this->logger()->debug('Receiving SQS messages...');
	    $result = $this->client->receiveMessage($this->config['SQS']['receive']);

	    $messages = $result->getPath('Messages');
	    $this->logger()->info('Messages received: ' . count($messages));

	    return $messages;
	}

	protected function finish($messages, $rawMessages)
	{
		$this->deleteMessages($messages);
	}

	public function deleteMessages(MessagesEvent $messages)
	{
		return;
		if ($this->notDelete)
		{
			return;
		}

		$time = time();
		$messagesToDelete = array();
		foreach ($messages->getMessages() as $key => $message)
		{
			if (@$message->isDeletable !== false)
			{
				$messagesToDelete[] = array(
					'Id' => $time . '-' . $key,
					'ReceiptHandle' => (string) $message->ReceiptHandle
				);
			}
		}

		try {
			if (count($messagesToDelete) > 0)
			{
				$this->client->deleteMessageBatch(array(
		            'QueueUrl' => $this->config['SQS']['receive']['QueueUrl'],
		            'Entries'  => $messagesToDelete,
		        ));
			}
		} catch (\Exception $e) {
			$this->logger()->critical('Error deleting messages: {}', array($e->getMessage()));
		}
	}
}