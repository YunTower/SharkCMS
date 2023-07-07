<?php
class admin extends FrameWork
{
    private $info;
    private $session;

    public function __construct()
    {
        // 登陆状态检测
        if (isset($_SESSION['token'])) {
            // ==>登陆
            // 获取session
            $this->session = $_SESSION['token'];
            // 解析session 获取uid
            $uid = json_decode(base64_decode($_SESSION['token']))->uid;
            $this->info = self::$_user->info($uid);
        } else {
            // ==>未登录
            include ADM . 'login.php';
            exit();
        }
    }

    public function index()
    {
        include ADM . 'index.php';
    }

    public function content()
    {
        include ADM . 'index.php';
    }

    public function login()
    {
        include ADM . 'index.php';
    }


    function test()
    {
        echo self::$_user->CreateToken('1');
    }
}