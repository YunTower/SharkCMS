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

namespace FrameWork\Captcha;

class Captcha
{
    public static function get()
    {
        $code = self::Code();
        if (isset($_SESSION['captcha'])) {
            unset($_SESSION['captcha']);
        }
        $_SESSION['captcha'] = $code;
        ob_clean();
        self::create($code);
    }

    public static function Code($count = 5)
    {
        $code = '';
        $charset = 'ABCDEFGHJKLMNPQRSTUVWXY23456789';
        $len = strlen($charset) - 1;
        for ($i = 0; $i < $count; $i++) {
            $code .= $charset[mt_rand(0, $len)];
        }
        return $code;
    }

    /**
     * 显示图形验证码
     * @param string $code
     */
    public static function create($code)
    {
        $width = 120; //验证码图片宽度
        $height = 35; //验证码图片高度
        $img = imagecreate($width, $height); //创建验证码图像
        //设置验证码图像的背景颜色
        imagecolorallocate($img, mt_rand(50, 255), mt_rand(0, 155), mt_rand(0, 155));
        $fontSize = 18; //验证码文字大小
        $fontColor = imagecolorallocate($img, 255, 255, 255); //验证码文字颜色
        $fontStyle = INC . 'static/font/STCAIYUN.TTF'; //验证码文字样式
        $len = strlen($code);
        //生成指定长度的验证码
        for ($i = 0; $i < $len; ++$i) {
            imagettftext(
                $img,
                $fontSize,
                mt_rand(0, 20) - mt_rand(0, 25),
                $fontSize * $i + 12,
                mt_rand($height / 2, $height),
                $fontColor,
                $fontStyle,
                $code[$i]
            );
        }
        //为验证码图片生成彩色噪点
        for ($i = 0; $i < 200; ++$i) {
            //随机生成颜色
            $color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            //随机绘制干扰点
            imagesetpixel($img, mt_rand(0, $width), mt_rand(0, $height), $color);
        }
        //绘制10条干扰线
        for ($i = 0; $i < 5; ++$i) {
            //随机生成干扰线颜色
            $color = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            //随机绘制干扰线
            imageline($img, mt_rand(0, $width), 0, mt_rand(0, $width), $height, $color);
        }
        header('Content-Type: image/png');
        imagepng($img); //输出图像
        imagedestroy($img); //释放内存
    }
}
