<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/YunTower/SharkCMS
 * @ Link：https://sharkcms.cn
 * @ License：https://gitee.com/YunTower/SharkCMS/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */

namespace FrameWork;

use Illuminate\Database\Capsule\Manager as DB;
use ReflectionClass;
use FrameWork\User\User;
use FrameWork\View\View;
use FrameWork\Plugin\Plugin;

class FrameWork
{
    // 配置信息
    public static $_App;
    public static $_view;
    public static $_http;
    public static $_cloud;
    public static $_data = null;
    public static $getSetting = [];


    /**
     * 框架初始化方法
     */
    public static function init()
    {
        $log_file = ERROR_LOG . 'error_' . date('Y-m-d') . '.log';
        fopen($log_file, "w");
        // 加载公共函数
        include_once INC . 'core/Function.php';
        // 设置异常&错误处理
        error_reporting(E_ALL);
        // set_exception_handler('exception_handler');
        // set_error_handler('custom_error_handler');

        // 检查安装状态
        if (APP_INSTALL == false) {
            if (self::getController() != 'install') {
                header('Location:/install/step/1');
            }
        } else {
            // 初始化数据库
            $capsule = new DB;
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

            // 主题名称
            define('vName', Db::table('sk_setting')->where('name', "theme-name")->first()->value);
            // 当前主题路径
            define('vPath', CON . 'theme/' . vName . '/');

            // 加载模块文件
            spl_autoload_register(function ($name) {
                $core_file = explode('\\', $name)[1];
                if (!empty($core_file) && $core_file != 'DBAL') {
                    $class_file = INC . 'core/inc/' . explode('\\', $name)[1] . '.php';
                    if (file_exists($class_file)) {
                        include_once INC . 'core/inc/' . explode('\\', $name)[1] . '.php';
                    }
                }
            });


            // 初始化用户模块
            User::init();
            // 初始化试图模块
            View::init();
            // 初始化插件模块
            Plugin::init();

            // 加载后台设置
            $data = (DB::table('sk_setting')->get());
            $data = json_decode(json_encode($data), true);
            foreach ($data as $res => $v) {
                self::$getSetting = self::$getSetting + [$v['name'] => $v['value']];
            }
        }
    }

    /**
     * 启动框架并执行控制器方法
     */
    public static function run()
    {
        //调用框架类方法，获取URLk中的控制器和方法
        $controller_action = self::controller_action();
        $controller = $controller_action['controller'];
        $action = $controller_action['action'];
        //拼接控制器类文件名称
        $class_file = INC . 'app/controller/' . $controller . '.php';

        if ($controller != 'sk-content') {
            if (file_exists($class_file)) {
                //加载控制器类文件
                require_once $class_file;
                //获取控制器类
                $class = new ReflectionClass($controller);
                //获取控制器类的实例
                $instance = $class->newInstanceArgs();
                //获取控制器类的所有方法
                $methods = $class->getMethods();
                //判断类中是否有$action方法
                $method = '';
                foreach ($methods as $obj) {
                    if ($obj->getName() == $action) {
                        $method = $class->getMethod($action);
                        break;
                    }
                }
                //若方法不存在，则跳转到错误控制器
                if ($method == '') {
                    if (self::getController() != 'admin') {
                        if (self::getAction() != 'index' && !is_numeric(self::getAction())) {
                            if (self::getAction() != 'index' && self::getAction() != 'index') {
                                self::WARNING(404);
                            }
                        }
                    }
                } else {
                    //执行方法
                    $method->invoke($instance);
                }
            } else {
                self::WARNING(404);
            }
        }
    }

    // 获取域名
    public static function getDomain()
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        return $http_type . $_SERVER['HTTP_HOST'];
    }

    // 获取url
    public static function getURL()
    {
        return $_SERVER["REQUEST_URI"];
    }

    // 获取入口文件
    public static function getFile()
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    // 获取uri
    public static function getURI()
    {
        $request = str_replace(self::getFile(), '', self::getURL());
        $request = ltrim($request, '/');
        $module_action = explode('?', $request)[0];
        return explode('/', $module_action);
    }

    // 获取控制器
    public static function getController()
    {
        if (isset(self::getURI()[0]) && !empty(self::getURI()[0])) {
            return htmlspecialchars(self::getURI()[0]);
        } else {
            return 'index';
        }
    }

    // 获取方法
    public static function getAction()
    {
        if (isset(self::getURI()[1]) && !empty(self::getURI()[1])) {
            return htmlspecialchars(self::getURI()[1]);
        } else {
            return 'index';
        }
    }

    // 获取参数
    public static function getData()
    {
        if (isset(self::getURI()[2]) && !empty(self::getURI()[2])) {
            return htmlspecialchars(self::getURI()[2]);
        } else {
            return null;
        }
    }


    // 整合参数
    public static function controller_action()
    {
        return array(
            'controller' => self::getController(),
            'action' => self::getAction(),
            'data' => self::getData()
        );
    }

    // 配置修改
    public static function setConfig(array $new)
    {
        $config = CONFIGS;
        $file = INC . 'config/app.php';
        $_new = var_export(array_replace_recursive($config, $new), true);
        file_put_contents($file, "<?php \n return $_new;\n");
    }


    // 获取来源
    public static function getOrigin()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }
    }

    public static function getIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        return $ip;
    }

    public static function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function importSQL($file)
    {
        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        // 检测连接
        if (!$mysqli) {
            die("连接失败: " . mysqli_connect_error());
        }
        // 读取.sql文件内容
        $sql = file_get_contents($file);
        // 执行SQL语句
        if (!$mysqli->multi_query($sql)) {
            //若导入失败
            return mysqli_error_list($mysqli);
        }
        // 清空结果集
        while ($mysqli->more_results() && $mysqli->next_result()) {
            $discard = $mysqli->use_result();
            if ($discard instanceof mysqli_result) {
                $discard->free();
            }
        }

        return true;
    }


    /***
     * @name 日志记录
     * @data
     * $type int 日志类型 (0 默认 1 错误)
     * $statusCode int 状态码 |
     * $msg string 日志内容
     * @return false|true
     */
    public static function log(int $statusCode, string $msg, int $type = 0)
    {
        switch ($type) {
            case 0:

                break;
        }
    }


    // 错误处理
    public static function WARNING(int $code, array $info = null)
    {
        ob_clean();
        if (self::getController() == 'api') {
            exit(json_encode(['code' => 404, 'msg' => '页面不存在']));
        }

        if (APP_INSTALL) {
            $file = CON . 'theme/' . vName . '/view/error/' . $code . '.php';
            if (file_exists($file)) {
                include_once $file;
            }
        } else if ($code == 0) {
            $title = $info[0];
            $msg = $info[1];
            include_once INC . 'view/error/error.php';
        } else {
            include_once INC . 'view/error/' . $code . '.php';
        }
        // 日志
        $t = date('Y-m-d H:i:s');
        $log = "【{$t}】[" . self::getURL() . "][" . self::getIp() . "]{$code} {$info}" . PHP_EOL;
        $file = fopen(ROOT . APP_LOGDIR . 'log_' . date('Y-m-d') . '.log', "a+");
        fwrite($file, $log);
        fclose($file);
        exit();
    }
}

// 工具类
class Utils
{
    /***
     * @name 解码数据
     * @data $method 请求方式(GET/POST)
     * @return false|json
     */
    public static function DecodeRequestData($method, $key)
    {

        if (isset($method) && isset($key)) {
            switch ($method) {
                case 'GET':
                    if (isset($_GET[$key])) {
                        return json_decode(base64_decode($_GET[$key]), true);
                    } else {
                        return false;
                    }
                    break;
                case 'POST':
                    if (isset($_POST[$key])) {
                        return json_decode(base64_decode($_POST[$key]), true);
                    } else {
                        return false;
                    }
                    break;
                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
    }

    public static function CreateCode($length = 8)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        // 在 $chars 中随机取 $length 个数组元素键名
        $keys = array_rand($chars, $length);
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 将 $length 个数组元素连接成字符串
            $password .= $chars[$keys[$i]];
        }
        return $password;
    }

    /**
     * 数据库分页
     * [$data](数据)
     * [pSize](每页显示数量)
     * [$pCount](页码)
     */
    public static function Pager(array $data, int $pSize = 15, int $pCount = 1)
    {

        $total = count($data); // 计算数组总数
        $total_page = ceil($total / $pSize); // 计算总页数
        $offset = ($pCount - 1) * $pSize;     // 计算当前数据起始位置
        $page_arr = array_slice($data, $offset, $pSize); // 截取数据作为当前页数据
        return array(
            'data' => $page_arr,   // 分页数据
            'total_page' => $total_page, // 总页数
            'total_count' => $total,   // 总记录数
            'page_count' => $pCount,     // 当前页码
            'page_size' => $pSize   // 每页数据条目数
        );
    }
}
