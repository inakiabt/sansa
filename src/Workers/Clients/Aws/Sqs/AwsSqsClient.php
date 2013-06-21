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

		$this->client = SqsClient::factory(array(
			'key'    => $config[AWS_ACCESS_KEY],
			'secret' => $config[AWS_SECRET_KEY],
			'region' => $config[SQS_REGION]
		));			
	}

	public function receiveMessages()
	{
	    $result = $this->client->receiveMessage(array(
	        'QueueUrl' => $this->config[SQS_QUEUE],
	        'MaxNumberOfMessages' => $this->config[SQS_MESSAGES]
	    ));

	    return $result->getPath('Messages/*/Body');
	}
}