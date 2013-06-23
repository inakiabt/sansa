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
		parent::__construct();
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
		if ($this->canAccept($message))
		{
			if ($this->isValid($message))
			{
				$this->doWork($validMessages);

				$this->processNext($message);
			}
		} else {
			$this->processNext($message);
		}
	}

	private function processNext($message)
	{
		if ($this->getContext()->get('status') === RUNNING && 
			$this->getContext($message)->get('status') === RUNNING && 
			$this->nextExecutor !== null)
		{
			$this->nextExecutor->process($message);
		}
	}

	private function doWork($message)
	{
		if ($this->getContext()->get('status') === RUNNING && 
			$this->getContext($message)->get('status') === RUNNING)
		{
			$this->doProcess($message);
		}
	}

	abstract protected function isValid($message);
	abstract protected function doProcess($message)
}