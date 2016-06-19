<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
require_once dirname(__FILE__).'/Consumer.php';
require_once dirname(__FILE__).'/models/Message.php';
require_once dirname(__FILE__).'/repositories/MessageRepository.php';
require_once dirname(__FILE__).'/repositories/MessageRepositoryOnSqs.php';

class Fixture {
    /**
     * @return Message[]
     */
    static function getMessages() {
        $message = new Message();
        $message->message = "hello";
        $message->receiptHandle = "receiptHandleCode";
        return array($message);
    }
}

class ConsumerTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    function test() {
        $this->assertEquals(2, 1 + 1);
    }

    /**
     * @test
     */
    function test_consuming() {
        $repo = new MockRepository();
        $consumer = new Consumer($repo);

        ob_start();
        $consumer->consuming(Fixture::getMessages());
        $actual = ob_get_clean();
        $expected = '[consume] hello'.PHP_EOL;
        $this->assertEquals($expected, $actual);
    }
}

class MockRepository implements MessageRepository {
    /**
     * @param DomainEvent $m
     */
    function publish($m)
    {
        return;
    }

    /**
     * @return DomainEvent[]
     */
    function subscribe()
    {
        return array(Fixture::getMessages());
    }

    /**
     * @param DomainEvent $m
     */
    function unsubscribe($m)
    {
        return;
    }
}
