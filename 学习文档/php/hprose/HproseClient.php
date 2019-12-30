<?php
namespace app\index\controller;

use Hprose\Completer;
use Hprose\Future;
use \Hprose\Http\Client;

class HproseClient
{
    public function hello()
    {
        $client = new \Hprose\Http\Client('http://localhost:81/index.php/index/Index/serverStart', false);
        $result = $client->hello('xujunjie');
        print_r($result);die;
    }
    public function test()
    {
        $client = new \Hprose\Socket\Client('tcp://127.0.0.1:1314', false);
        $result = $client->hello();
        echo $result;die;
    }
    //异步
    public function test1()
    {
        $client = new Client('http://localhost:81/index.php/index/Index/serverStart', true);
        $client->mySum(1, 1000000)->then(function($result){
                var_dump($result);
            });
        // $va = $client->mySum(1, 1000000);
        // $promise = Future\value($va);
        // $promise->then(function($value) {
        //     var_dump($value);
        // });
        echo 'xujunjie';
    }
    public function test2(){
        Future\co(function() {
            $test = new Client("http://localhost:81/index.php/index/Index/serverStart", true);
            var_dump((yield $test->hello("hprose")));
            $a = $test->mySum(1, 100);
            $b = $test->mySum(1, 1000);
            var_dump((yield $test->sum($a, $b)));
            var_dump((yield $test->hello("world")));
        });
    }
}




  

