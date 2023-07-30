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

            if (!empty($_GET['_pjax'])) {
                $action = self::getAction();
                $data = self::getData();
                if ($data) {
                    $file = $action . '/' . $data . '.php';
                } else {
                    if ($action == 'index') {
                        $file = 'console.php';
                    } else {
                        $file = $action . '.php';
                    }
                }

                if (file_exists(ADM . $file)) {
                    exit(View::pjax($file));
                } else {
                    self::Error('404', '糟了，页面不见了！');
                }
            } else {
                $code = 200;
                $file = self::getAction() . '/' . self::getData() . '.php';
                if (!self::getData()) {
                    if (self::getAction() == 'index') {
                        $file =  'console.php';
                    } else {
                        $file = self::getAction() . '.php';
                    }
                }
                if (!file_exists($file)) {
                    $code = 404;
                }
                $code;
                $file;
                include_once ADM . 'index.php';
            } 
        } else {
            // ==>未登录
            if (self::getAction() != 'reg') {
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
}
