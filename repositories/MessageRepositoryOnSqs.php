<?php

use Infrastructure\SqsProvider;

/**
 * Class MessageRepositoryOnSqs
 */
class MessageRepositoryOnSqs implements MessageRepository {

    /**
     * Repository constructor.
     */
    function __construct() {
        $this->sqs = SqsProvider::getSqs();
        $this->sqsUrl = SqsProvider::myQueueUrl;
    }

    /**
     * @var \Aws\Sqs\SqsClient
     */
    private $sqs;

    /**
     * @var string
     */
    private $sqsUrl;

    /**
     * @param Message $m
     */
    function unsubscribe($m) {
        $this->sqs->deleteMessage(array(
            'QueueUrl'      => $this->sqsUrl,
            'ReceiptHandle' => $m->receiptHandle,
        ));
    }

    /**
     * @return Message[]
     */
    function subscribe() {
        $received = $this->sqs->receiveMessage(array(
            'QueueUrl' => $this->sqsUrl,
        ));

        $messages = array();
        foreach ((array)$received->get('Messages') as $m) {
            $messages[] = Message::createFromMessage($m);
        }

        return $messages;
    }

    /**
     * @param Message $m
     */
    function publish($m) {
        echo "[publish] message: {$m->message}", PHP_EOL;

        $this->sqs->sendMessage(array(
            'QueueUrl'    => $this->sqsUrl,
            'MessageBody' => $m->message,
        ));
    }

}
