<?php
namespace Sansa;

use lf4php\LoggerFactory;
use WorkContext;

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
		$this->logger = LoggerFactory::getLogger(__CLASS__);
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