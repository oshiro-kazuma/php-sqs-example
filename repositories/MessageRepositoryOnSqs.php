<?php
require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/../models/message.php';
require_once dirname(__FILE__).'/SqsProvider.php';
require_once dirname(__FILE__) . '/MessageRepository.php';

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
