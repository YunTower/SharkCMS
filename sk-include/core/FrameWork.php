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
        if (file_exists($class_file)) {
            //加载基础控制器类
            $controller_file = INC . 'application/controller/Controller.php';
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
            exit('非法访问！');
        }
    }
    /**
     * 获取URL中的控制器与方法
     */
    public static function controller_action()
    {
        //设置默认控制器
        $controller = DEFAULT_CONTROLLER;
        //设置默认方法
        $action = DEFAULT_ACTION;
        $data = null;
        //获取请求的URI
        $request_uri = $_SERVER['REQUEST_URI'];
        //获取请求的入口文件
        $script_name = $_SERVER['SCRIPT_NAME'];
        //获取URL中的控制器、方法和查询字符串
        $request = str_replace($script_name, '', $request_uri);
        $request = ltrim($request, '/');
        if (!empty($request)) {
            //分离查询字符串
            $request_array = explode('?', $request);
            //分离控制器和方法
            $controller_action = $request_array[0];
            $controller_action = explode('/', $controller_action);
            //获取控制器
            $controller = ucfirst($controller_action[0]);
            //获取方法
            if (!empty($controller_action[1])) {
                $action = $controller_action[1];
            }
            // 获取参数
            if (!empty($controller_action[2])) {
                $data = $controller_action[2];
            }
        }
        //以关联数组形式返回URL中的控制器和方法
        return array(
            'controller' => $controller,
            'action' => $action,
            'data' => $data
        );
    }
}
