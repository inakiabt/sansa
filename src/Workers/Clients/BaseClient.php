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
		$messages = $this->doReceiveMessages();

		foreach ($messages as $i => $message)
		{
			$messages[$i]->context = array();
		}
	}

	abstract protected function doReceiveMessages();
}