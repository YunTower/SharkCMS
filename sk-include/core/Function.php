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

// 错误处理
function custom_error_handler($errno, $errstr, $errfile, $errline)
{
    ob_clean();
    error_log("[" . date('Y-m-d H:i:s') . "]Error: [$errno] $errstr\n", 3, ERROR_LOG . 'error_' . date('Y-m-d') . '.log');
    include_once INC . 'view/error/error_code.php';
}

// 异常处理
function exception_handler(Throwable $exception)
{
    $title = '系统错误';
    $msg = $exception->getMessage();
    error_log("[" . date('Y-m-d H:i:s') . "]Error: $msg\n", 3, ERROR_LOG . 'error_' . date('Y-m-d') . '.log');
    include_once INC . 'view/error/error.php';
}


function toArray($data)
{
    return json_decode(json_encode($data), true);
}

function getRunTime()
{
    $sitestart = strtotime(APP_TIME);
    $sitenow = time();
    $sitetime = $sitenow - $sitestart;
    $sitedays = (int)($sitetime / 86400);
    return $sitedays;
}
