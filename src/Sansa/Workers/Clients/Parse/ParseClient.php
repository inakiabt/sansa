<?php
namespace Sansa\Workers\Clients\Parse;

use Sansa\Events\MessagesEvent;
use Sansa\Workers\Clients\BaseClient;
use Parse\Rest\Client as Parse;

abstract class ParseClient extends BaseClient
{
    function __construct($config, $notDelete = false)
    {
        parent::__construct($config);
    }

    public function setEventDispatcher($dispatcher)
    {
        parent::setEventDispatcher($dispatcher);

        $this->getEventDispatcher()->addListener('messages:invalid', array($this, 'onInvalidMessages'));
    }

    protected function doReceiveMessages()
    {
        $this->logger()->debug('Querying Parse for results...');
        $messages = $this->query();

        $this->logger()->info('Messages received: ' . count($messages));

        return $messages;
    }

    public function onInvalidMessages(MessagesEvent $messages)
    {
        $this->deleteMessages($messages->getMessages());
    }

    public function finish($messages, $rawMessages)
    {
        $this->deleteMessages($messages);
    }

    public function deleteMessages($messages)
    {
        $this->logger()->info('[ParseClient] Skip Deleting messages ('.count($messagesToDelete).')...');
        return;
    }

    abstract protected function query();
}