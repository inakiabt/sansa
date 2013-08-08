<?php
namespace Sansa\Workers;

use Sansa\Base;
use Sansa\Workers\Clients\BaseClient;
use Sansa\Executors\BaseExecutor;

/**
* Base Worker
*/
class BaseWorker extends Base
{
	private $config = array();

	private $client = null;
	private $executor = null;
	private $validator = null;
	private $preProcessor = null;

	function __construct($config)
	{
		parent::__construct();
		$this->config = $config;
	}

	public function setClient(BaseClient $client)
	{
		$this->client = $client;
		$this->client->setEventDispatcher($this->getEventDispatcher());
	}

	public function getClient()
	{
		return $this->client;
	}

	public function setPreProcessor($preProcessor)
	{
		$this->preProcessor = $preProcessor;
		$this->preProcessor->setEventDispatcher($this->getEventDispatcher());
	}

	public function getPreProcessor()
	{
		return $this->preProcessor;
	}

	public function setExecutor(BaseExecutor $executor)
	{
		$this->executor = $executor;
		$this->executor->setEventDispatcher($this->getEventDispatcher());

		return $this->executor;
	}

	public function getExecutor()
	{
		return $this->executor;
	}

	public function setFilter($filter)
	{
		$this->filter = $filter;
		$this->filter->setEventDispatcher($this->getEventDispatcher());

		return $this->filter;
	}

	public function getFilter()
	{
		return $this->filter;
	}

	public function start()
	{
		$rawMessages = $this->getClient()->receiveMessages();
		if (count($rawMessages) > 0)
		{
			$messages = $this->getPreProcessor()->preProcess($rawMessages);

			$filteredMessages = $this->getFilter()->filter($messages);
			if (count($filteredMessages) > 0)
			{
				$this->getExecutor()->process($filteredMessages, $rawMessages);
			}

			$this->finish($messages, $rawMessages);
		}
	}

	protected function finish($messages, $rawMessages)
	{
		
	}
}