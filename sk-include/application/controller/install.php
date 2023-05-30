<?php

class install extends Controller
{
    private $_step;

    public function __construct()
    {
        // 判断是否安装
        if (APP_INSTALL != false) {
            header("Location: /");
            exit();
        }
    }

    public function index()
    {
        include_once  INC . 'view/install/index.php';
    }

    public function step()
    {
        // 步骤数
        $this->_step = FrameWork::getData();
        // if 步骤数 == 0 || null  ==> 步骤数 =1
        if ($this->_step == null || $this->_step == 0) {
            $this->_step = 1;
        }
        // 加载页面
        include_once INC . 'view/install/step_' . $this->_step . '.php';
    }

    public function ok()
    {
        include_once INC . 'view/install/ok.php';
    }

    public function install()
    {
        // 判断请求是否是ajax请求
        $ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(trim($_SERVER['HTTP_X_REQUESTED_WITH'])) == 'xmlhttprequest');
        if (!$ajax) {
            exit('403 无权访问页面');
        } else {
        }
    }
}
