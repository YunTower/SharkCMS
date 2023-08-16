<?php

class User extends FrameWork
{
    // 登陆状态
    public static $loginStatus = false;
    // 用户角色
    public static $userRole;
    // 用户信息
    public static $userInfo;

    public function __construct()
    {
       if (FrameWork::inStatus()){
           @$token = $_SESSION['token'];
           // 验证登陆状态
           if (isset($token)) {
               $info = self::$_db->table('sk_user')->where("token = '$token'")->find();

               // 验证token真实性
               if($info){
                   if (count($info) >= 1) {
                       self::$loginStatus = true;
                       self::$userInfo = $info;
                       self::$userRole = $info['group'];
                   }
               }
           }
       }
    }

    public static function CreateToken($id)
    {
        $time = time();
        // 生成Token
        $token = base64_encode(json_encode(array('uid' => $id, 'time' => $time)));
        // 保存Token
        self::$_db->table('sk_user')->where("uid = $id")->update(array('token' => $token));
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function info($id)
    {
        return self::$_db->table('sk_user')->where('uid = "' . $id . '"')->find();
    }

    public function encode_pwd($pwd, $t)
    {
        return md5(md5($pwd) . $t);
    }
}
