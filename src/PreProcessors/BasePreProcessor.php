<?php
namespace Sansa\PreProcessors;

use Sansa\Base;

/**
* BasePreProcessor
*/
class BasePreProcessor extends Base
{
	function __construct()
	{
		parent::__construct();
	}
	public function preProcess($message)
	{
		return $message;
	}
}