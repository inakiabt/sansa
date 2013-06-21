<?php
namespace Sansa\PreProcessors;

use Sansa\Base;

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