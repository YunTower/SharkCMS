<?php

/**
 * 基础控制器
 * 控制器基类
 * @author weiwenping        
 */
class Controller
{

    public static function Domain()
	{
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		return $http_type . $_SERVER['HTTP_HOST'];
	}
    /**
     * 构造方法
     */
    public function __construct()
    {

        // 设置session缓存目录
        session_save_path(CON . 'temp/session');

        // 开启session缓存
        session_start();
        //加载库文件
        $lib_file = INC . 'core/inc/cloud.php';
        $lib_file = INC . 'core/inc/db.php';
        $lib_file = INC . 'core/inc/system.php';
        $lib_file = INC . 'core/inc/theme.php';
        if (file_exists($lib_file)) {
            include_once $lib_file;
        } else {
            exit('库文件加载失败！');
        }
        
    }

    /**
     * 加载视图
     * @param string $view
     * @param array $data
     */
    protected function view($view, $data = NULL)
    {
        //加载视图文件
        $file = VIEW_PATH . $view . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            exit('非法访问！');
        }
    }
}
