<?php

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
