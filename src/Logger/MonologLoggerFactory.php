<?php
namespace Sansa\Logger;

/**
* 
*/
class MonologLoggerFactory
{
	private static $logger;
	private static $loggers = array();

	public static function setLogger(MonologWrapper $logger)
	{
		self::$logger = $logger;
	}

	public static function getLogger($name)
	{
		if (!isset(self::$loggers[$name]))
		{
			$newLogger = new MonologWrapper($name);
			foreach (self::$logger->getHandlers() as $handler)
			{
				$newLogger->pushHandler($handler);
			}
			foreach (self::$logger->getProcessors() as $processor)
			{
				$newLogger->pushProcessor($processor);
			}
			self::$loggers[$name] = $newLogger;
		}

		return self::$loggers[$name];
	}
}