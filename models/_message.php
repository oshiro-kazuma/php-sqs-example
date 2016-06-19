<?php

/**
 * Interface DomainEvent
 */
abstract class DomainEvent {
    /**
     * @return string
     */
    function __toString() {
        return json_encode($this);
    }
}

/**
 * Class Message
 */
class Message extends DomainEvent {

    /**
     * @param array $message SQS Message
     * @return Message
     */
    static function createFromMessage(array $message) {
        $m = new Message();
        $m->message = $message['Body'];
        $m->receiptHandle = $message['ReceiptHandle'];
        return $m;
    }

    /**
     * Message constructor.
     * @param string $message
     */
    function __construct($message = null) {
        $this->message = $message;
    }

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $receiptHandle;
}
