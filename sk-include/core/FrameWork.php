<?php

class FrameWork
{
    // 配置信息
    public static $_App;
    public static $_db;
    public static $_view;
    public static $_user;
    public static $_http;
    public static $_cloud;
    // 数据传输变量
    public static $_data = null;

    /**
     * 框架初始化方法
     */
    public static function init()
    {
        //加载配置文件
        $config_file = INC . 'config/app.php';
        if (file_exists($config_file)) {
            self::$_App = include $config_file;
        } else {
            exit('没有找到配置文件！');
        }

        // 检查安装状态
        if (!self::inStatus()) {

            if (self::getController() != 'install') {
                header('Location:/install/');
            }
        } else {
            // 加载模块文件
            include_once INC . 'core/inc/Db.php';
            include_once INC . 'core/inc/User.php';
            include_once INC . 'core/inc/Http.php';
            include_once INC . 'core/inc/Hook.php';
            include_once INC . 'core/inc/View.php';
            include_once INC . 'core/inc/Plugin.php';
            include_once INC . 'core/inc/Cloud.php';

            // 初始化类
            if (FrameWork::$_App['db']['Host']) {
                $_db = FrameWork::$_App['db'];
            }

            self::$_db = Db::getInstance($dbHost = $_db['Host'], $dbUser = $_db['User'], $dbPasswd = $_db['Pwd'], $dbName = $_db['Name'], $dbCharset = '');
            self::$_user = new User();
            self::$_view = new View();
            self::$_http = new Http();
            self::$_cloud = new Cloud();
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
                    if (FrameWork::getController() != 'admin') {
                        if (self::getAction() != 'index' && !is_numeric(self::getAction())) {
                            if (self::getAction() != 'index' && self::getAction() != 'index'){
                            self::Error(404);

                        }}
                    }
                } else {
                    //执行方法
                    $method->invoke($instance);
                }
            } else {
                self::Error(404);
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
            return self::getURI()[0];
        } else {
            return 'index';
        }
    }

    // 获取方法
    public static function getAction()
    {
        if (isset(self::getURI()[1]) && !empty(self::getURI()[1])) {
            return self::getURI()[1];
        } else {
            return 'index';
        }
    }

    // 获取参数
    public static function getData()
    {
        if (isset(self::getURI()[2]) && !empty(self::getURI()[2])) {
            return self::getURI()[2];
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
        $config = self::$_App;
        $file = INC . 'config/app.php';
        $_new = var_export(array_replace_recursive($config, $new), true);
        file_put_contents($file, "<?php \n return $_new;\n");
    }

    // 安装状态
    public static function inStatus()
    {
        return self::$_App['app']['Install'];
    }

    // 获取来源
    public static function getOrigin()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }
    }

    // 错误处理
    public static function Error(int $code, array $info = null)
    {
        ob_clean();
        $file = CON . 'theme/' . View::$vName . '/page/error/' . $code . '.php';
        if (file_exists($file)) {
            include_once $file;
        } else if ($code == 0) {
            $title = $info['title'];
            $msg = $info['msg'];
            include_once INC . 'view/error/error.php';
        } else {
            include_once INC . 'view/error/' . $code . '.php';
        }
        exit();
    }
}
