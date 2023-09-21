<?php

use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\Main as FrameWork;
use FrameWork\User\User;
use FrameWork\View\View;

class Admin
{
    private $info;
    private $session;

    public function __construct()
    {
        // 登陆状态检测

        if (User::$loginStatus) {
            // ==>登陆
            $this->info = User::$userInfo;
            if (FrameWork::getAction() != 'view') {
                include_once ADM . 'index.php';
            }
        } else {
            // ==>未登录
            if (FrameWork::getAction() != 'reg') {
                if (isset(explode('/', FrameWork::getOrigin())[4]) && explode('/', FrameWork::getOrigin())[4] == 'article') {
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

    public function view()
    {
        if (isset($_GET['page'])) {
            if (file_exists(ADM . $_GET['page'])) {
                if (explode('/', $_GET['page'])[0] == 'view') {
                    include_once ADM . htmlentities($_GET['page']);
                } else {
                    FrameWork::Error(404);
                }
            } else {
                FrameWork::Error(404);
            }
        } else {
            echo 1;
        }
    }

}
