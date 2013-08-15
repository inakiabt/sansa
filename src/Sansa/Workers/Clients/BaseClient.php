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

	public function receiveMessages()
	{
		return $this->doReceiveMessages();
	}

	public function finish($messages, $rawMessages)
	{
		
	}

	abstract protected function doReceiveMessages();
}