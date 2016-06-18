<?php

/**
 * Interface DomainEvent
 */
interface DomainEvent { }

/**
 * Class Message
 */
class Message implements DomainEvent {

    /**
     * @param array $message SQS Message
     * @return Message
     */
    static function createFromMessage(/*array*/$message) {
        $m = new Message("");
        $m->message = $message['Body'];
        $m->receiptHandle = $message['ReceiptHandle'];
        return $m;
    }

    /**
     * Message constructor.
     * @param string $message
     */
    function __construct($message) {
        $this->message = $message;
    }

    /**
     * @return string
     */
    function __toString() {
        return json_encode($this);
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
