<?php
class User extends FrameWork
{
    private $token;

    public function __construct()
    {
        if (isset($_SESSION['token'])) {
        }
    }

    public function CreateToken($id)
    {
        $time = time();
        // 生成Token
        $token = base64_encode(json_encode(array('uid' => $id, 'time' => $time)));
        // 保存Token
        self::$_db->table('sk_user')->insert(array('token' => $token));
        $this->token = $token;
        $_SESSION['token'] = $token;
        return $token;
    }

    public function info($id)
    {
        return self::$_db->table('sk_user')->where('uid = "' . $id . '"')->select();
    }

    public function encode_pwd($pwd)
    {
        return md5(md5($pwd).time());
    }
}
