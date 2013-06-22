<?php
namespace Sansa\Workers\Clients;

use Sansa\Base;

abstract class BaseClient extends Base {
	protected $config = null;

	function __construct($config)
	{
		parent::__construct();
		$this->config = $config;
	}

	abstract public function receiveMessages();
}