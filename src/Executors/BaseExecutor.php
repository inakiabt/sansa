<?php
namespace Sansa\Executors;

use Sansa\Base;

/**
* BaseExecutor
*/
abstract class BaseExecutor extends Base
{
	private $nextExecutor = null;

	function __construct($nextExecutor = null)
	{
		if ($nextExecutor !== null)
		{
			$this->setNext($nextExecutor);
		}
	}

	public function setNext($nextExecutor)
	{
		$this->nextExecutor = $nextExecutor;
		$this->nextExecutor->setEventDispatcher($this->getEventDispatcher());

		return $this->nextExecutor;
	}

	public function process($messages, $rawMessages = null)
	{
		if ($this->doProcess($messages, $rawMessages) !== false)
		{
			if ($this->nextExecutor !== null)
			{
				$this->nextExecutor->process($messages, $rawMessages);
			}
		}
	}

	abstract protected function doProcess($messages, $rawMessages = null);
}