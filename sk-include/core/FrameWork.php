<?php

class FrameWork
{

    /**
     * 构造方法
     */
    public function __construct()
    {
        include_once INC . 'core/inc/db.php';
    }


    /**
     * 框架初始化方法
     */
    public static function init()
    {
        //加载配置文件;
        $config_file = INC . 'config/app.ini';
        if (file_exists($config_file)) {
            $config = parse_ini_file($config_file);
            foreach ($config as $key => $value) {
                define(strtoupper($key), "$value");
            }
        } else {
            exit('没有找到配置文件！');
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
        $class_file = INC . 'application/controller/' . $controller . '.php';
        if ($controller != 'sk-content') {
            if (file_exists($class_file)) {
                //加载基础控制器类
                $controller_file = INC . 'application/controller/controller.php';
                if (file_exists($controller_file)) {
                    require_once $controller_file;
                }
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
                    ob_clean();
                    exit('页面不存在');
                }
                //执行方法
                $method->invoke($instance);
            } else {
                exit('非法访问');
            }
        }
    }

    // 获取域名
    public static function Domain()
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
            return DEFAULT_CONTROLLER;
        }
    }

    // 获取方法
    public static function getAction()
    {
        if (isset(self::getURI()[1]) && !empty(self::getURI()[1])) {
            return self::getURI()[1];
        } else {
            return DEFAULT_ACTION;
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

    /**
     * 获取URL中的控制器与方法
     */
    public static function controller_action()
    {
        return array(
            'controller' => self::getController(),
            'action' => self::getAction(),
            'data' => self::getData()
        );
    }
}
