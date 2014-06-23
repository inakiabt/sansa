<?php
namespace Sansa\Workers\Clients\File;

use Sansa\Events\MessagesEvent;
use Sansa\Workers\Clients\BaseClient;

class FileClient extends BaseClient
{
	private $client = null;
	private $notDelete = false;
	function __construct($config, $notDelete = false)
	{
		parent::__construct($config);
	}

	public function setEventDispatcher($dispatcher)
	{
		parent::setEventDispatcher($dispatcher);

		$this->getEventDispatcher()->addListener('messages:invalid', array($this, 'onInvalidMessages'));
	}

	protected function doReceiveMessages()
	{
		$this->logger()->debug('Receiving File json messages...');
	    $messages = json_decode(file_get_contents($this->config['messages_file']));

	    $this->logger()->info('Messages received: ' . count($messages));

	    return $messages;
	}

	public function onInvalidMessages(MessagesEvent $messages)
	{
		$this->deleteMessages($messages->getMessages());
	}

	public function finish($messages, $rawMessages)
	{
		$this->deleteMessages($messages);
	}

	public function deleteMessages($messages)
	{
		if ($this->notDelete)
		{
			return;
		}
		$time = time();
		$messagesToDelete = array();
		foreach ($messages as $key => $message)
		{
			if (@$message->isDeletable !== false)
			{
				$messagesToDelete[] = array(
					'Id' => $time . '-' . $key
				);
			}
		}

		$this->logger()->info('[FileClient] Skip Deleting messages ('.count($messagesToDelete).')...');
	}
}