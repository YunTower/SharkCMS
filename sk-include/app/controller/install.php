<?php

class install extends FrameWork
{
    private $_step;

    public function index()
    {
        include_once  INC . 'view/install/index.php';
    }

    public function step()
    {
        // 获取当前步骤
        $this->_step = FrameWork::getData();

        // 步骤数
        // if 步骤数 == 0 || null  ==> 步骤数 =1
        if ($this->_step == null || $this->_step == 0) {
            $this->_step = 1;
        }

        // 加载页面
        include_once INC . 'view/install/step_' . $this->_step . '.php';
    }

    public function install()
    {
        header('Content-Type: application/json; charset=utf-8');
        // 判断请求是否是ajax请求
        $ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(trim($_SERVER['HTTP_X_REQUESTED_WITH'])) == 'xmlhttprequest');
        if (!$ajax) {
            exit(json_encode(array('code' => 1003, 'msg' => '请求无效', 'error' => null)));
        } else {
            $data = file_get_contents("php://input");
            $data = base64_decode($data);
            $data = json_decode($data, true);

            switch (FrameWork::getData()) {
                    // 数据库连接
                case 'connect';
                    $conn = new mysqli($data['db_host'], $data['db_user'], $data['db_pwd'], $data['db_name']);
                    if ($conn->connect_error) {
                        ob_clean();
                        exit(json_encode(array('code' => 1008, 'msg' => '数据库连接失败', 'error' => $conn->connect_error)));
                    } else {
                        exit(json_encode(array('code' => 1000, 'msg' => '数据库连接成功', 'error' => null)));
                    }
                    break;

                case 'install';
                    // 导入数据表
                    
                    if (self::$_db->import(INC . 'config/db.sql')) {
                        // 写入初始数据
                        $pwd = self::$_user->encode_pwd($data['ad_pwd']);
                        self::$_db->table('sk_user')->insert(array('uid' => '1', 'name' => $data['ad_name'], 'pwd' => $pwd, 'group' => 'admin'));
                        self::$_db->table('sk_content')->insert(array('title' => 'Hello SharkCMS', 'slug'=>'你好！世界！','content' => '当你看到这篇文章的时候，说明SharkCMS已经安装成功了，删除这篇文章，开始创作吧！', 'uid' => '1', 'uname' => $data['ad_name']));
                        exit(json_encode(array('code' => 1000, 'msg' => '安装成功', 'error' => null)));
                    } else {
                        exit(json_encode(array('code' => 1003, 'msg' => '系统安装失败', 'error' => null)));
                    }
                    exit(json_encode(array('code' => 1000, 'msg' => '安装成功', 'error' => null)));
                    break;

                default:
                    exit(json_encode(array('code' => 1003, 'msg' => '请求无效', 'error' => null)));
                    break;
            }
        }
    }
}
