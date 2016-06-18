<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
require_once dirname(__FILE__).'/repositories/repository.php';

$repo = new Repository();
$consumer = new Consumer($repo);
$consumer->start();

class Consumer {

    /**
     * Consumer constructor.
     * @param Repository $repository
     */
    function __construct($repository) {
        $this->repository = $repository;
    }

    /**
     * @var Repository
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
                        printf("[error] sqs_message:%s".PHP_EOL, $m);
                        echo $e->getMessage();
                        echo $e->getTraceAsString();
                    }
                }

                echo "[main] consume sqs end.", PHP_EOL;
                sleep(2);

            } catch (Exception $e) {
                echo $e->getMessage();
                echo $e->getTraceAsString(), PHP_EOL;
                sleep(60);
            }
        }
    }
}

