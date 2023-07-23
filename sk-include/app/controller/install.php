<?php

class install extends FrameWork
{
    private $_step;

    public function __construct()
    {
        if (self::$_App['app']['Install'] && self::getData() != 3) {
            self::Error('系统提示', '你已安装SharkCMS，无需再次安装');
        }
    }

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
            exit(json_encode(array('code' => 400, 'msg' => '请求无效', 'error' => null)));
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
                        exit(json_encode(array('code' => 500, 'msg' => '数据库连接失败', 'error' => $conn->connect_error)));
                    } else {
                        self::setConfig(['db' => array('Host' => $data['db_host'], 'User' => $data['db_user'], 'Pwd' => $data['db_pwd'], 'Name' => $data['db_name'], 'Charset' => 'utf-8')]);
                        exit(json_encode(array('code' => 200, 'msg' => '数据库连接成功', 'error' => null)));
                    }
                    break;

                case 'install';
                    // 加载内核依赖
                    include_once INC . 'core/inc/db.php';
                    include_once INC . 'core/inc/user.php';
                    include_once INC . 'core/inc/http.php';

                    // 初始化类
                    self::$_db = new DB();
                    self::$_user = new User();
                    self::$_http=new Http();

                    if (self::$_db->import(INC . 'config/db.sql')) {
                        // 写入初始数据
                        // var_dump($data);
                        // echo $data['ad_mail'];
                        $t = time();
                        $pwd = self::$_user->encode_pwd($data['ad_pwd'], $t);
                        self::$_db->table('sk_user')->insert(array('uid' => 1, 'name' => $data['ad_name'], 'pwd' => $pwd, 'mail' => $data['ad_mail'],'avatar'=>'/sk-content/upload/avatar/default.webp', 'group' => 'admin', 'created' => $t));
                        self::$_db->table('sk_content')->insert(array('title' => 'Hello SharkCMS', 'slug' => '你好！世界！', 'content' => '当你看到这篇文章的时候，说明SharkCMS已经安装成功了，删除这篇文章，开始创作吧！', 'category' => 'SharkCMS', 'tag' => 'default', 'uid' => 1, 'uname' => $data['ad_name']));
                        self::$_db->table('sk_category')->insert(array('name' => 'SharkCMS', 'cid' => 1, 'uid' => 1, 'uname' => $data['ad_name']));
                        self::$_db->table('sk_tag')->insert(array('name' => 'default', 'cid' => 1, 'uid' => 1, 'uname' => $data['ad_name']));

                        $arr =self::$_http->post('install', self::$_App, 'json');
                        
                        // $arr=json_decode($arr,true);
                        // var_dump($arr);
                        if ($arr['code'] == 200) {

                            // 写入信息
                            self::setConfig(['app' => ['Install' => true, 'Time' => date('Y-m-d H:i:s')],'api' => ['Key' => $arr['data']['key'], 'Token' => $arr['data']['token']]]);

                            exit(json_encode(array('code' => 200, 'msg' => '安装成功', 'error' => null)));
                        } else {
                            exit(json_encode(array('code' => 400, 'msg' => $arr['msg'], 'error' => null)));
                        }
                    } else {
                        exit(json_encode(array('code' => 500, 'msg' => '安装出错', 'error' => self::$_db->error())));
                    }
                    var_dump($data);
                    break;

                default:
                    exit(json_encode(array('code' => 400, 'msg' => '请求无效', 'error' => null)));
                    break;
            }
        }
    }
}
