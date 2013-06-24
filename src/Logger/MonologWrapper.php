<?php
namespace Sansa\Logger;

use Monolog\Logger;

class MonologWrapper extends Logger
{
	public function getHandlers()
	{
		return $this->handlers;
	}

	public function getProcessors()
	{
		return $this->processors;
	}
}