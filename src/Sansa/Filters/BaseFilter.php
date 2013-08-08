<?php
namespace Sansa\Filters;

use Sansa\Base;

/**
* BaseFilter
*/
abstract class BaseFilter extends Base
{
	private $nextFilter = null;

	function __construct($nextFilter = null)
	{
		parent::__construct();
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
		if ($this->nextFilter !== null && count($filteredMessages) > 0)
		{
			return $this->nextFilter->filter($filteredMessages);
		}
		return $filteredMessages;
	}

	protected function invalidMessages($messages, $reason = '')
	{
	}

	abstract protected function doFilter($messages);
}