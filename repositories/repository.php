<?php
require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/sqs_provider.php';

use Infrastructure\SqsProvider;

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
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $receiptHandle;
}

/**
 * Interface SqsEventRepository
 */
interface SqsEventRepository {
    /**
     * @param DomainEvent $m
     * @return
     */
    function publish($m);

    /**
     * @return DomainEvent[]
     */
    function subscribe();

    /**
     * @param DomainEvent $m
     * @return
     */
    function unsubscribe($m);
}

/**
 * Class Repository
 */
class Repository implements SqsEventRepository {

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
