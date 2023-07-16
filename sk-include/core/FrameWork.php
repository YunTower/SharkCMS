<?php

class FrameWork
{

    public static $_App;
    public static $_db;
    public static $_view;
    public static $_user;
    public static $_http;
    public static $_cloud;

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
            include_once INC . 'core/inc/db.php';
            include_once INC . 'core/inc/user.php';
            include_once INC . 'core/inc/view.php';
            include_once INC . 'core/inc/http.php';
            include_once INC . 'core/inc/cloud.php';

            // 初始化类
            self::$_db = new DB();
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
                        self::Error('404 页面不存在', '你所访问的页面不存在');
                    }
                } else {
                    //执行方法
                    $method->invoke($instance);
                }
            } else {
                self::Error('404 页面不存在', '你所访问的页面不存在');
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
    public static function setConfig($new)
    {
        $config = self::$_App;
        $file = INC . 'config/app.php';
        $_new = var_export(array_replace_recursive($config, $new), true);
        file_put_contents($file, "<?php \n return $_new;\n");
    }

    // 安装状态
    public static function inStatus(){
        return self::$_App['app']['Install'];
    }


    // 错误处理
    public static function Error($title, $msg)
    {
        ob_clean();
        $title;
        $msg;
        include_once INC . 'view/error/error.php';
        exit();
    }
}
