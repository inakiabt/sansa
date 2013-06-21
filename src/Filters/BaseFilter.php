<?php
namespace MessageProcessor\Filters;

use MessageProcessor\Base;

/**
* BaseFilter
*/
abstract class BaseFilter extends Base
{
	private $nextFilter = null;

	function __construct($nextFilter = null)
	{
		if ($nextFilter != null)
		{
			$this->setNext($nextFilter);
		}
	}

	public function setNext($nextFilter)
	{
		$this->nextFilter = $nextFilter;
		$this->nextFilter->setEventDispatcher($this->getEventDispatcher());

		return $this->nextFilter;
	}

	public function filter($messages)
	{
		$filteredMessages = $this->doFilter($messages);
		if ($this->nextFilter !== null)
		{
			return $this->nextFilter->filter($filteredMessages);
		}
		return $filteredMessages;
	}

	abstract protected function doFilter($messages);
}