<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
require_once dirname(__FILE__).'/repositories/sqs_provider.php';
require_once dirname(__FILE__) . '/repositories/messageRepositoryOnSqs.php';

use Infrastructure\SqsProvider;

$sqs = SqsProvider::getSqs();

$repo = new MessageRepositoryOnSqs();
$producer = new Producer($repo);
$producer->publish();

class Producer {

    /**
     * Producer constructor.
     * @param MessageRepository $repository
     */
    function __construct(MessageRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @var MessageRepository
     */
    private $repository;

    /**
     * @var string[]
     */
    private $messages = ["hello", "good bye!", "hey!", "こんにちは", "はいさい"];

    function publish() {
        $m = new Message($this->messages[array_rand($this->messages)]);
        $this->repository->publish($m);
    }

}
