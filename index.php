<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.cn
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */

use FrameWork\FrameWork;

header('Content-Type: text/html; charset=utf-8');
// 系统根目录
define('ROOT', str_replace('\\', '/', __DIR__) . '/');
// 系统文件目录
define('INC', ROOT . 'sk-include/');
// 内容存储目录
define('CON', ROOT . 'sk-content/');
// 系统后台目录
define('ADM', ROOT . 'sk-admin/');
// 错误日志目录
define('ERROR_LOG', CON . 'temp/log/error/');
// 设置运行模式
define('DEBUG',true);

// PHP版本检查
if (PHP_VERSION < '8.0.2') {
    exit ("版本检查：你的PHP版本过于老旧，请使用 <a style='color:red'>等于或高于8.0.2</a> 的版本！<br>");
}

// 读写权限检查
!is_writeable(CON) and exit("权限检查：目录'/sk-content/' 无读写权限，请检查！linux请设置为777！<br>");
!is_writeable(INC) and exit("权限检查：目录'/sk-include/' 无读写权限，请检查！<linux></linux>请设置为777！<br>");

// 设置session缓存目录
session_save_path(CON . 'temp/session');

// 开启session缓存
session_start();

// 设置全局变量CONFIG_FILE，使其指向INC目录下的app.php文件
$GLOBALS['CONFIG_FILE'] = INC . 'config/app.php';

// 检查CONFIG_FILE是否存在
if (file_exists($GLOBALS['CONFIG_FILE'])) {
    // 初始化一个空数组DEFINED_DATA，用于存储配置文件中定义的数据
    $GLOBALS['DEFINED_DATA'] = [];
    define('ConfigFile',$GLOBALS['CONFIG_FILE']);
    // 使用include_once函数包含CONFIG_FILE，并将结果存储在foreach循环中
    foreach (include_once $GLOBALS['CONFIG_FILE'] as $key => $arr) {
        // 遍历数组中的每个键值对
        foreach ($arr as $name => $value) {
            // 将键值对添加到DEFINED_DATA数组中
            $GLOBALS['DEFINED_DATA'][] = [$name, $value, $key];
        }
    }
    // 遍历DEFINED_DATA数组中的每个数据项
    foreach ($GLOBALS['DEFINED_DATA'] as $data) {
        // 将键名转换为大写，并添加下划线，以生成定义的变量名
        $name = strtoupper($data[2]) . '_' . strtoupper($data[0]);
        // 检查变量是否已定义
        if (!defined($name)) {
            // 定义变量并输出其值
            define($name, $data[1]);
        }
    }
} else {
    // 如果CONFIG_FILE不存在，输出错误信息
    exit('系统提示：没有找到配置文件！');
}

// 自动加载
require_once INC . 'vendor/autoload.php';

// 框架文件
include_once INC . 'core/FrameWork.php';

// 框架初始化
FrameWork::init();

// 启动程序
FrameWork::run();
