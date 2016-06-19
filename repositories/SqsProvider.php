<?php
namespace Infrastructure;

class SqsProvider {

    const myQueueUrl = 'https://ap-northeast-1.queue.amazonaws.com/XXXXXXXXX/XXXX';

    /**
     * @return \Aws\Sqs\SqsClient
     */
    static function getSqs() {
        return $sqs = new \Aws\Sqs\SqsClient(array(
            'region'    => 'ap-northeast-1',
            'version'   => '2012-11-05',
        ));
    }

}
