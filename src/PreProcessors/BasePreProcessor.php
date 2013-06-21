<?php
namespace MessageProcessor\PreProcessors;

use MessageProcessor\Base;

/**
* BasePreProcessor
*/
class BasePreProcessor extends Base
{
	public function preProcess($message)
	{
		return $message;
	}
}