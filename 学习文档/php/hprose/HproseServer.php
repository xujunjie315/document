<?php
namespace app\index\controller;

use Hprose\Http\Server;

class HproseServer
{
    public function index()
    {
        echo 'xujunjie';
    }
    public function hello($name) 
    {
        return 'hello ' . $name;
    }
    public function mySum($a,$b)
    {
        $number = 0;
        for($i=$a;$i<=$b;$i++){
            $number += $i;
        }
        return $number;
    }
    //启动服务
    public function serverStart()
    {
        $server = new Server();
        $server->addInstanceMethods($this);
        $server->debug = true;
        $server->crossDomain = true;
        $server->start();
    }
}





  

