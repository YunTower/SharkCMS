<?php
class admin
{
    private $_user;
    private $_db;
    private $info;
    private $session;

    function __construct()
    {
        // 初始化user类
        $this->_user = new USER();
        // 初始化db类
        $this->_db = new DB();
        // 登陆状态检测
        if (!isset($_SESSION['token'])) {
            // ==>未登录
            include ADM . 'login.php';
            exit();
        } else {
            // ==>登陆
            // 获取session
            $this->session = $_SESSION['token'];
            // 解析session 获取uid
            $uid=json_decode(base64_decode($_SESSION['token']))->uid;
            $this->info = $this->_user->info($uid);
        }
    }

    function login()
    {
        include ADM . 'login.php';
    }

    function index()
    {
        include ADM . 'index.php';
    }

    function content()
    {
        include ADM . 'index.php';
    }

    function page()
    {
        include ADM . 'index.php';
    }

    function user()
    {
        include ADM . 'index.php';
    }

    function module()
    {
        include ADM . 'index.php';
    }

    function set()
    {
        include ADM . 'index.php';
    }

    function about()
    {
        include ADM . 'index.php';
    }

    function test()
    {
        // echo $_SESSION['captcha'];
        $user = new USER();
        echo $user->CreateToken('1');
    }
}
