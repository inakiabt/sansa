<?php
namespace Sansa;

/**
* Base
*/
class Base
{
	private $eventDispatcher = null;

	public function getEventDispatcher()
	{
		return $this->eventDispatcher;
	}

	public function setEventDispatcher($eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;
	}
}