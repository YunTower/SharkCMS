<?php


/**
 * --------------------------------------------------------------------------------
 * @ Author：fish (https://gitee.com/fish_nb)
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.icu
 * @ License：MIT License (https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE)
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */

header('Content-Type: text/html; charset=utf-8');
// 系统基础信息
define('App_N', 'SharkCMS');
define('App_V', '1.0.0-dev.6');
define('App_T', 'Develop');
// 云端接口地址
define('API_HOST', 'https://api.sharkcms.cn/');
// 云端接口版本
define('API_V','v1');
// 运行模式 0->线上模式（日志） 1->开发模式（报错+日志）
define('DEBUG', '1');
// 系统根目录
define('ROOT', str_replace('\\', '/', __DIR__) . '/');
// 系统文件目录
define('INC', ROOT . 'sk-include/');
// 系统安装目录
define('INS', ROOT . 'sk-install/');
// 内容存储目录
define('CON', ROOT . 'sk-content/');
// 系统后台目录
define('ADM', ROOT . 'sk-admin/');

// PHP版本检查
if (PHP_VERSION < '7.0') {
    echo ("版本检查：你的PHP版本过于老旧，请使用 <a style='color:red'>等于或高于7.0</a> 的版本！<br>");
} else if (PHP_VERSION > '8.1') {
    echo ("版本检查：你的PHP版本过高，目前暂不支持8.x，使用过高的版本可能会出现语法不兼容的情况。<br>");
}

// 读写权限检查
!is_writeable(CON) and exit("权限检查：目录'/sk-content/' 无读写权限，请检查！linux请设置为777！<br>");
!is_writeable(INC) and exit("权限检查：目录'/sk-include/' 无读写权限，请检查！linux请设置为777！<br>");

// 加载系统类
include_once INC . 'System.class.php';

// 加载数据库类
include_once INC . 'Db.class.php';

// 加载主题类
include_once INC . 'Theme.class.php';

// 初始化类库
$Route = new Route;
$System = new System;
$Theme = new Theme;

// 设置session存储路径
session_save_path(CON . 'temp/session');

// 开启session缓存
session_start();

// 启动路由
$Route->Run();
