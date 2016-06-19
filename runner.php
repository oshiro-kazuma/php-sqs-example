<?php
require_once dirname(__FILE__).'/vendor/autoload.php';
require_once dirname(__FILE__).'/Consumer.php';
require_once dirname(__FILE__).'/Producer.php';
require_once dirname(__FILE__).'/models/Message.php';
require_once dirname(__FILE__).'/repositories/SqsProvider.php';
require_once dirname(__FILE__).'/repositories/MessageRepository.php';
require_once dirname(__FILE__).'/repositories/MessageRepositoryOnSqs.php';

$target = $argv[1];

if($target === 'consumer') {

    $repo = new MessageRepositoryOnSqs();
    $consumer = new Consumer($repo);
    $consumer->start();

} else if($target === 'producer') {

    $repo = new MessageRepositoryOnSqs();
    $producer = new Producer($repo);
    $producer->publish();

} else {

    die("usage: php ${argv[0]} (consumer|producer)". PHP_EOL);

}
