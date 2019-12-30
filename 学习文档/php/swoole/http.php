<?php

class Http {
    CONST HOST = '0.0.0.0';
    CONST PORT = 8901;
    public $server;
    public function __construct(){
        $this->server = new swoole_http_server(self::HOST,self::PORT);
        $this->server->set([
            'enable_static_handle' => true,
            'document_root' => "/home/work/hdtocs/swoole"
        ]);
        $this->server->on('request',[$this,'onRequest']);
        $this->server->start();
    }
    public function onRequest($request,$response){
        $content = [
            'date' => date('Y-m-d H:i:s'),
            'get' => $request->get,
            'post' => $request->post,
            'header' => $request->header,
        ];
        swoole_async_writefile(__DIR__ . '/access.log',json_decode($content) . PHP_EOL,function($filename){
            //TODO
        },FILE_APPEND);
        $response->cookie('singwa','xsssss',time()+1800);
        $response->end('sss',json_decode($request->get));
    }

}
$object = new Http();