<?php

class Ws {
    CONST HOST = '0.0.0.0';
    CONST PORT = 8901;
    public $server;
    public function __construct(){
        $this->server = new swoole_websocket_server(self::HOST,self::POSR);
        $this->server->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);
        $this->server->on('open',[$this,'onOpen']);
        $this->server->on('message',[$this,'onMessage']);
        $this->server->on('task',[$this,'onTask']);
        $this->server->on('finish',[$this,'onFinish']);
        $this->server->on('close',[$this,'onClose']);
        $this->server->start();
    }
    public function onOpen($serv,$request) {
        var_dump($request->fd);
        if($request->fd == 1){
            swoole_timer_tick(2000,function($timeId){
                echo "2s:timeId:{$timeId}\n";
            });
        }
    }
    public function onMessage($serv,$frame){
        echo "ser-push-message:{$frame->data}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];
        $serv->task($data);
        swoole_timer_after(5000,function() use ($serv,$frame) {
            echo "5s-after\n";
            $serv->push($frame->fd,"serve-time-after");
        });
        $serv->push($frame->fd,"serve-push:" . date('Y-m-d H:i:s'));
    }
    public function onTask($serv,$taskId,$workerId,$data){
        print_r($data);
        sleep(10);
        return "on task finish";
    }
    public function onFinish($serv,$taskId,$data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-sucess:{$data}\n";
    }
    public function onClose($serv,$fd){
        echo "clientId:{$fd}\n";
    }
}
$object = new Ws();