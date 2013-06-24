<?php
namespace Sansa;

use Sansa\Logger\MonologLoggerFactory;

/**
* Base
*/
class Base
{
	private $logger;
	private $eventDispatcher = null;
	private $context = null;

	public function __construct()
	{
		$this->logger = MonologLoggerFactory::getLogger(__CLASS__);
		$this->context = WorkContext::getInstance();
	}

	public function logger()
	{
		return $this->logger;
	}

	public function getEventDispatcher()
	{
		return $this->eventDispatcher;
	}

	public function setEventDispatcher($eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;
	}
}