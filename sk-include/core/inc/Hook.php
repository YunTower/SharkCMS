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

namespace FrameWork\Hook;

use FrameWork\Plugin\Plugin;

class Hook
{
    /**
     * 监听已注册的插件
     *
     * @access private
     * @var array
     */
    static $_listeners = [];

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public static function init()
    {
        $plugins = Plugin::$plugin_config;
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if ($plugin['use']) {
                    if (file_exists($plugin['path'] . '/index.php')) {
                        include_once($plugin['path'] . '/index.php');
                        $class = $plugin['app']['Class'];
                        if (class_exists($class)) {
                            //初始化所有插件
                            new $class();
                        }

                    }
                }

            }

        }
        #此处做些日志记录方面的东西
    }

    /**
     * 注册需要监听的插件方法（钩子）
     *
     * @param string $hook
     * @param object $reference
     * @param string $method
     */
    public static function do($hook, &$reference, $method)
    {
        //获取插件要实现的方法
        $key = get_class($reference) . '->' . $method;
        //将插件的引用连同方法push进监听数组中
        self::$_listeners[$hook][$key] = array(&$reference, $method);
        #此处做些日志记录方面的东西
    }

    /**
     * 触发一个钩子
     *
     * @param string $hook 钩子的名称
     * @param mixed $data 钩子的入参
     * @return mixed
     */
    public static function add($hook, $data = '')
    {
        self::init();
        $result = '';
        //查看要实现的钩子，是否在监听数组之中
        if (isset(self::$_listeners[$hook]) && is_array(self::$_listeners[$hook]) && count(self::$_listeners[$hook]) > 0) {
            // 循环调用开始
            foreach (self::$_listeners[$hook] as $listener) {
                // 取出插件对象的引用和方法
                $class =& $listener[0];
                $method = $listener[1];
                if (method_exists($class, $method)) {
                    // 动态调用插件的方法
                    $result .= $class->$method($data);
                }
            }
        }
        #此处做些日志记录方面的东西
        return $result;
    }
}