<?php
namespace MessageProcessor\Workers\Clients;

use MessageProcessor\Base;

abstract class BaseClient extends Base {
	protected $config = null;

	function __construct($config)
	{
		$this->config = $config;
	}

	abstract public function receiveMessages();
}