<?php
namespace Sansa;

class WorkContext
{
	private $elements = array();

	private function __construct()
	{
	}

	public static function getInstance()
	{
		static $inst = null;
		if ($inst === null)
		{
			$inst = new WorkContext();
		}
		return $inst;
	}

	public function set($name, $element)
	{
		$this->elements[$name] = $element;
	}

	public function get($name)
	{
		return $this->elements[$name];
	}
}