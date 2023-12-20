<?php

use Illuminate\Database\Capsule\Manager as DB;
use WpOrg\Requests\Requests;
use FrameWork\FrameWork;
use FrameWork\User\User;
use FrameWork\Utils;

class Install
{
    private $_step;

    public function __construct()
    {

        if (APP_INSTALL && FrameWork::getController() == 'install' && FrameWork::getData() != 4) {
            if (FrameWork::getData() != 3 && FrameWork::getController() == 'install' && FrameWork::getData() != 4) {
                FrameWork::WARNING(0, ['系统提示', '你已安装过了SharkCMS，如需重置系统请前往：后台->关于->重置，进行操作']);
            }
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

        if (!isset($_SESSION['install_step']) || $_SESSION['install_step'] > 4) {
            $_SESSION['install_step'] = 1;
        }

        if ($_SESSION['install_step'] == $this->_step && $_SESSION['install_step'] < 5) {
            if (isset(explode('/', FrameWork::getOrigin())[5]) && explode('/', FrameWork::getOrigin())[5] == 1) {
                $_SESSION['install_step'] = 2;
                include_once INC . 'view/install/step_' . $_SESSION['install_step'] . '.php';
            } else {
                include_once INC . 'view/install/step_' . $_SESSION['install_step'] . '.php';
            }
        } else if ($this->_step != $_SESSION['install_step']) {
            header('Location:/install/step/' . $_SESSION['install_step']);
        }
    }

    public function install()
    {
        header('Content-Type: application/json; charset=utf-8');
        // 判断请求是否是ajax请求
        if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
            jsonMsg(400, '请求无效');
        } else {
            $data = Utils::DecodeRequestData('POST', 'data');

            switch (FrameWork::getData()) {
                // 数据库连接
                case 'connect';
                    $conn = new mysqli($data['db_host'], $data['db_user'], $data['db_pwd'], $data['db_name']);
                    if ($conn->connect_error) {
                        jsonMsg(500, '数据库连接失败：' . $conn->connect_error);
                    } else {
                        FrameWork::setConfig(['db' => array('Host' => $data['db_host'], 'User' => $data['db_user'], 'Pwd' => $data['db_pwd'], 'Name' => $data['db_name'], 'Charset' => 'utf8')]);
                        $_SESSION['install_step'] += 1;
                        jsonMsg(200, '数据库连接成功');
                    }
                    break;

                case 'install';

                    require_once INC . 'vendor/autoload.php';
                    $capsule = new Db;
                    $capsule->addConnection([
                        'driver' => 'mysql',
                        'host' => DB_HOST,
                        'database' => DB_NAME,
                        'username' => DB_USER,
                        'password' => DB_PWD,
                        'charset' => DB_CHARSET,
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
                    $arr = Requests::post(API_HOST . 'addUser', $headers, json_encode(CONFIGS));
                    $arr = json_decode($arr->body, true);
                    if ($arr['code'] == 200) {
                        if (FrameWork::importSQL(INC . 'config/db.sql')) {
                            // 写入初始数据
                            $t = time();
                            $pwd = User::encode_pwd($data['ad_pwd'], $t);
                            DB::table('sk_user')->insert(array('name' => $data['ad_name'], 'pwd' => $pwd, 'mail' => $data['ad_mail'], 'avatar' => '/sk-content/upload/avatar/default.webp', 'role' => 'admin', 'ban' => false, 'ua' => FrameWork::getUserAgent(), 'created' => $t));
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
                            jsonMsg(500, '数据库安装出错');
                        }
                        // 写入信息
                        FrameWork::setConfig(['App' => ['Install' => true, 'Time' => date('Y-m-d H:i:s')], 'Api' => ['Key' => $arr['data']['key'], 'Token' => $arr['data']['token']]]);
                        User::CreateToken(1);
                        $_SESSION['install_step'] += 1;
                        jsonMsg(200, '安装成功');
                    } else {
                        jsonMsg(500, '云端连接错误：' . $arr['msg']);
                    }
                    break;

                default:
                    jsonMsg(400, '请求无效');
                    break;
            }
        }
    }
}
