<?php

captcha_img(55555);
/**
 * 生成验证码
 * @param int $count 验证码长度
 * @return string
 */
function create_captcha($count=5) {
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
function captcha_img($code) {
    $width = 120;//验证码图片宽度
    $height = 35;//验证码图片高度
    $img = imagecreate($width, $height);//创建验证码图像
    //设置验证码图像的背景颜色
    imagecolorallocate($img, mt_rand(50,255), mt_rand(0,155), mt_rand(0,155));    
    $fontSize = 18;//验证码文字大小
    $fontColor = imagecolorallocate($img, 255, 255, 255);//验证码文字颜色
    $fontStyle = site_domain() . '/sk-include/static/font/font.ttf';//验证码文字样式
    $len = strlen($code);
    //生成指定长度的验证码
    for($i=0; $i<$len; ++$i){  
        imagettftext(
            $img, 
            $fontSize,
            mt_rand(0,20) - mt_rand(0,25),//设置验证码文字倾斜角度
            //随机设置验证码文字显示坐标
            $fontSize * $i + 12,
            mt_rand($height/2, $height),             
            $fontColor,  
            $fontStyle,  
            $code[$i] 
         );
    }
    //为验证码图片生成彩色噪点
    for($i=0; $i<200; ++$i){
        //随机生成颜色
        $color = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        //随机绘制干扰点
        imagesetpixel($img,mt_rand(0,$width),mt_rand(0,$height),$color);
    }    
    //绘制10条干扰线
    for($i=0; $i<5; ++$i){
        //随机生成干扰线颜色
        $color = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        //随机绘制干扰线
        imageline($img,mt_rand(0,$width),0,mt_rand(0,$width),$height,$color);
    }    
    header('Content-Type: image/png'); 
    imagepng($img);//输出图像
    imagedestroy($img);//释放内存
}
/**
 * 检查验证码是否正确
 * @param string $captcha
 * @return boolean
 */
function captcha_check($captcha) {    
    if ($captcha == $_SESSION['wmcms']['captcha']) {
        return true;
    }
    return false;
}