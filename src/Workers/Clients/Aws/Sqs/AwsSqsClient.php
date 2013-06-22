<?php
namespace Sansa\Workers\Clients\Aws\Sqs;

use Sansa\Workers\Clients\BaseClient;
use Aws\Sqs\SqsClient;

/**
* SQS Client
*/
class AwsSqsClient extends BaseClient
{
	private $client = null;
	function __construct($config)
	{
		parent::__construct($config);

		$this->client = SqsClient::factory($config['SQS']['init']);
	}

	protected function doReceiveMessages()
	{
	    $result = $this->client->receiveMessage($this->config['SQS']['receive']);

	    return $result->getPath('Messages/*/Body');
	}
}