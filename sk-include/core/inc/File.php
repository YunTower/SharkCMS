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

    public static function Upload($file, $dir)
    {
        if (isset($file) && isset($dir)) {
            try {
                move_uploaded_file($file, $dir);
                return ['code' => 200, 'msg' => '上传成功', 'data' => ['url' => FrameWork::getDomain() . '/sk-content/upload/avatar/' . $_FILES["file"]["name"]]];
            } catch (Exception $e) {
                return ['code' => 500, 'msg' => $e->getMessage()];
            }

        }
    }

    public static function fileName($file)
    {
        if (is_file($file) && file_exists($file)) {
            $file = new static();
            $file->filename = $file;
            return $file;

        } else {
            $file = new static;
            $file->filename = false;
            var_dump($file);
            return $file;
        }
    }

    public function create($type)
    {
        if ($this->filename) {
            fopen($this->filename, $type);
            return true;
        } else {
            return false;
        }
    }
}