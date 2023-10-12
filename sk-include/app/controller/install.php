<?php

use Illuminate\Database\Capsule\Manager as DB;
use WpOrg\Requests\Requests;
use FrameWork\Main as FrameWork;
use FrameWork\User\User;

class Install
{
    private $_step;

    public function __construct()
    {
        if (FrameWork::$_App['app']['Install'] && FrameWork::getData() != 3) {
            FrameWork::Error(0, array('title' => '系统提示', 'msg' => '你已安装过了SharkCMS，如需重置系统请前往：后台->关于->重置，进行操作'));
        }
    }

    public function index()
    {
        include_once INC . 'view/install/index.php';
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
        if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
            exit(json_encode(array('code' => 400, 'msg' => '请求无效', 'error' => $_SERVER['HTTP_X_REQUESTED_WITH'])));
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
                        FrameWork::setConfig(['db' => array('Host' => $data['db_host'], 'User' => $data['db_user'], 'Pwd' => $data['db_pwd'], 'Name' => $data['db_name'], 'Charset' => 'utf8')]);
                        exit(json_encode(array('code' => 200, 'msg' => '数据库连接成功', 'error' => null)));
                    }
                    break;

                case 'install';
                    require_once INC . 'vendor/autoload.php';
                    $capsule = new Db;
                    $capsule->addConnection([
                        'driver' => 'mysql',
                        'host' => FrameWork::$_App['db']['Host'],
                        'database' => FrameWork::$_App['db']['Name'],
                        'username' => FrameWork::$_App['db']['User'],
                        'password' => FrameWork::$_App['db']['Pwd'],
                        'charset' => FrameWork::$_App['db']['Charset'],
                        'collation' => 'utf8_unicode_ci',
                        'prefix' => '',
                    ]);
                    $capsule->setAsGlobal();
                    $capsule->bootEloquent();
                    // 加载依赖
                    include_once INC . 'core/inc/User.php';

                    // 初始化类
                    User::init();

                    $headers = array('Content-Type' => 'application/json');
                    $arr = Requests::post(FrameWork::$_App['api']['Host'] . 'install', $headers, json_encode(FrameWork::$_App));
                    $arr = json_decode($arr->body, true);
                    if ($arr['code'] == 200) {
                        if (FrameWork::importSQL(INC . 'config/db.sql')) {
                            // 写入初始数据
                            $t = time();
                            $pwd = User::encode_pwd($data['ad_pwd'], $t);
                            DB::table('sk_user')->insert(array('uid' => 1, 'name' => $data['ad_name'], 'pwd' => $pwd, 'mail' => $data['ad_mail'], 'avatar' => '/sk-content/upload/avatar/default.webp', 'role' => 'admin', 'created' => $t));
                            DB::table('sk_content')->insert(array('title' => 'Hello SharkCMS', 'slug' => '你好！世界！', 'content' => '当你看到这篇文章的时候，说明SharkCMS已经安装成功了，删除这篇文章，开始创作吧！', 'category' => 'SharkCMS', 'tag' => 'default', 'uid' => 1, 'uname' => $data['ad_name']));
                            DB::table('sk_category')->insert(array('name' => 'SharkCMS', 'cid' => 1, 'uid' => 1, 'uname' => $data['ad_name']));
                            DB::table('sk_tag')->insert(array('name' => 'default', 'cid' => 1, 'uid' => 1, 'uname' => $data['ad_name']));
                            $data =
                                [
                                    ['name' => 'Site-Title', 'value' => 'SharkCMS'],
                                    ['name' => 'Site-Subtitle', 'value' => '中国人自己的开源内容管理系统'],
                                    ['name' => 'Site-Logo', 'value' => '/sk-include/static/img/logo.png'],
                                    ['name' => 'Site-HeaderCode', 'value' => ''],
                                    ['name' => 'Site-FooterCode', 'value' => ''],
                                    ['name' => 'Article-PageSize', 'value' => 15],
                                    ['name' => 'Article-AllowComment', 'value' => true],
                                    ['name' => 'User-AllowReg', 'value' => false],
                                    ['name' => 'Comment-Examined', 'value' => false],
                                    ['name' => 'Comment-PostLoginComments', 'value' => true],
                                    ['name' => 'Comment-PSize', 'value' => 15],
                                    ['name' => 'Seo-Keyword', 'value' => 'SharkCMS',],
                                    ['name' => 'Seo-Description', 'value' => '又一个SharkCMS站点']
                                ];
                            Db::table('sk_setting')->insert($data);
                        } else {
                            exit(json_encode(['code' => 200, 'msg' => '数据库安装出错']));
                        }
                        // 写入信息
                        FrameWork::setConfig(['app' => ['Install' => true, 'Time' => date('Y-m-d H:i:s')], 'api' => ['Key' => $arr['data']['key'], 'Token' => $arr['data']['token']]]);
                        User::CreateToken(1);
                        exit(json_encode(array('code' => 200, 'msg' => '安装成功', 'error' => null)));
                    } else {
                        exit(json_encode(['code' => 500, 'msg' => '云端连接出错：' . $arr['msg']]));
                    }
                    break;

                default:
                    exit(json_encode(array('code' => 400, 'msg' => '请求无效', 'error' => null)));
                    break;
            }
        }
    }
}
