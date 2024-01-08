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

namespace FrameWork\File;

use FrameWork\FrameWork;

class File
{
    private $filename;

    public static function Upload($file, $dir, $path)
    {
        if (isset($file) && isset($dir)) {
            try {
                move_uploaded_file($file, $dir);
                return ['code' => 200, 'msg' => '上传成功', 'data' => ['url' => FrameWork::getDomain() . '/sk-content/' . $path . $_FILES["file"]["name"]]];
            } catch (Exception $e) {
                return ['code' => 500, 'msg' => $e->getMessage()];
            }
        }
    }

    public static function isDirectoryInParent($directoryPath, $parentDirectory)
    {
        // 获取目标目录的真实路径
        $targetDir = realpath($directoryPath);

        if ($targetDir === false || !is_dir($targetDir)) {
            return false; // 目录不存在或无法获取其真实路径
        }

        // 获取父目录的真实路径
        $parentDir = realpath($parentDirectory);

        if ($parentDir === false || !is_dir($parentDir)) {
            return false; // 父目录不存在或无法获取其真实路径
        }

        // 比较目标目录与父目录的前缀部分
        return strpos($targetDir, $parentDir . DIRECTORY_SEPARATOR) === 0;
    }

}
