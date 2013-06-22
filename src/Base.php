<?php
namespace Sansa;

use lf4php\LoggerFactory;

/**
* Base
*/
class Base
{
	private $logger;
	private $eventDispatcher = null;

	public function __construct()
	{
		$this->logger = LoggerFactory::getLogger(__CLASS__);
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