<?php
class Cloud extends FrameWork
{
    private $link;

    public function __construct()
    {
        // 连接服务器
        $this->link=$this->connect();
    }

    public function connect(){

    }
}
