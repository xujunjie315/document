<?php

namespace app\index\controller;

class Jpush
{
    /**
     * 获取token
     */
    public function test(){

        $client = new \JPush\Client('80c5c020c4f7d25942af8fbf', '2635daf32fc181e88e5090b5');
        $push = $client->push();
        $ciArr = $push->getCid($count = 1, $type = 'push');
        // var_dump($push->setCid($ciArr['body']['cidlist'][0])
        //     ->setPlatform(['android'])
        //     ->addAllAudience()
        //     ->androidNotification('hello',array(
        //         'sound' => 'hello jpush',
        //         'badge' => 2,
        //         'content-available' => true,
        //         'category' => 'jiguang',
        //         'extras' => array(
        //             'key' => 'value',
        //             'jiguang'
        //         ),
        //     ))
        //     ->send());

        $report = $client->report();
        print_r($report->getReceived('2251833830135506'));

        $device = $client->device();

        $schedule = $client->schedule();
    }
}