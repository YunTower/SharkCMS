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
        } 
    }
}
