<?php

class Admin extends FrameWork
{
    private $info;
    private $session;

    public function __construct()
    {
        // 登陆状态检测
        if (User::$loginStatus) {
            // ==>登陆
            $this->info =User::$userInfo;
            if(FrameWork::getAction()!='view'){
                include_once ADM.'index.php';
            }

        } else {
            // ==>未登录
            if (self::getAction() != 'reg') {
                if (isset(explode('/', self::getOrigin())[4]) && explode('/', self::getOrigin())[4] == 'article') {
                    FrameWork::$_data = json_encode(['from' => 'article']);
                }
                include ADM . 'login.php';
                exit();
            }
        }
    }


    public function login()
    {
        include ADM . 'index.php';
    }

    public function reg()
    {
        include ADM . 'reg.php';
    }

    public function view(){
        if (isset($_GET['page'])){
            if (file_exists(ADM.$_GET['page'])){
include_once ADM.$_GET['page'];

            }else{
                FrameWork::Error(404);
            }
        }else{
            echo 1;
        }
    }
}
