<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
require_once dirname(__FILE__) . '/repositories/messageRepository.php';

$repo = new MessageRepository();
$consumer = new Consumer($repo);
$consumer->start();

class Consumer {

    /**
     * Consumer constructor.
     * @param MessageRepository $repository
     */
    function __construct($repository) {
        $this->repository = $repository;
    }

    /**
     * @var MessageRepository
     */
    private $repository;

    /**
     * @param Message $m
     */
    function consume($m) {
        echo "[consume] {$m->message}", PHP_EOL;
        $this->repository->unsubscribe($m);
    }

    function start() {
        while(true) {
            echo "[main] consume sqs start.", PHP_EOL;
            try {
                $messages = $this->repository->subscribe();

                foreach ($messages as $m) {
                    try {
                        $this->consume($m);
                    } catch (Exception $e) {
                        echo "[error] sqs_message: $m", PHP_EOL;
                        echo $e->getMessage();
                        echo $e->getTraceAsString();
                    }
                }

                echo "[main] consume sqs end.", PHP_EOL;
                sleep(2);

            } catch (Exception $e) {
                echo "[error] sqs consume", PHP_EOL;
                echo $e->getMessage();
                echo $e->getTraceAsString(), PHP_EOL;
                sleep(60);
            }
        }
    }
}

