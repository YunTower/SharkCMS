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
    if (DEBUG) {
        include_once INC . 'view/error/error_code.php';
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            jsonMsg(500, '系统运行时发生了一些错误');
        } else {
            \FrameWork\FrameWork::WARNING(0, ['系统错误', '系统运行时发生了一些错误']);
        }
    }
}

// 异常处理
function exception_handler(Throwable $exception)
{
    ob_clean();
    $title = '系统错误';
    $msg = $exception->getMessage();
    error_log("[" . date('Y-m-d H:i:s') . "]Error: $msg\n", 3, ERROR_LOG . 'error_' . date('Y-m-d') . '.log');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        jsonMsg(500, $msg);
    } else {
        include_once INC . 'view/error/error.php';
    }
    exit();
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

function jsonMsg(int $code, $msg, array $data = null)
{
    exit(json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]));
}

function bytesToSize($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' B';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' B';
    } else {
        $bytes = '0 B';
    }
    return $bytes;
}
