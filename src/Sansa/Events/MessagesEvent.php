<?php
namespace Sansa\Events;

interface MessagesEvent {
	public function getMessages();
	public function getReason();
}