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

namespace FrameWork\Plugin;

use FrameWork\FrameWork;

class Plugin
{

    public static $plugin_list = [];
    public static $plugin_config = [];
    public static $plugin_error_msg = [];

    public static function init()
    {
        // 扫描目录
        $dir = scandir(CON . 'plugin/');
        unset($dir[0]);
        unset($dir[1]);
        $dir = array_values($dir);

        // 生成路径
        foreach ($dir as $d) {
            $_dir = $url = CON . 'plugin/' . $d;
            $url = FrameWork::getDomain() . '/sk-content/plugin/' . $d . '/';
            $url = array($d => ['url' => $url, 'dir' => $_dir]);
            self::$plugin_list = self::$plugin_list + $url;
        }

        // 读取配置
        self::$plugin_config = [];
        foreach (self::$plugin_list as $k => $v) {
            if (is_dir($v['dir'])) {
                $c = $v['dir'] . '/plugin.config.php';
                if (file_exists($c)) {
                    $b = include_once $v['dir'] . '/plugin.config.php';
                    $b = $b + ['dir' => $k, 'path' => $v['dir'], 'url' => $v['url']];
                    self::$plugin_config = self::$plugin_config + array($b['app']['Name'] => $b);
                } else {
                    self::$plugin_error_msg = ["位于【{$v['dir']}】内的插件由于缺少配置文件，因此无法加载"];
                }
            }
        }
    }

    public static function Static($type, $plugin, $file)
    {
        if ($type == 'css') {
            echo '<link rel="stylesheet" href="' . self::$plugin_config[$plugin]['url'] . $file . '"/>' . PHP_EOL;
        } else if ($type == 'js') {
            echo '<script src="' . self::$plugin_config[$plugin]['url'] . $file . '"></script>' . PHP_EOL;

        }
    }

    public static function import($plugin, $file)
    {
        include_once self::$plugin_config[$plugin]['path'] . '/' . $file;
    }

    public static function setConfig(string $name, array $content)
    {
        $config = self::$plugin_config[$name];
        $file = $config['path'] . '/plugin.config.php';
        if (file_exists($file)) {
            unset($config['dir']);
            unset($config['path']);
            unset($config['url']);
            $_new = var_export(array_replace_recursive($config, $content), true);
            if (file_put_contents($file, "<?php \n return $_new;\n")) {
                return true;
            }
        }

    }

    public static function del_plugin($path)
    {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$path/$file")) ? deleteDirectory("$path/$file") : unlink("$path/$file");
            }
            return rmdir($path);
        }
    }

}