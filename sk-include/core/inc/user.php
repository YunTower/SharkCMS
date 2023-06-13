<?php
class USER extends FrameWork
{
    private $_db;
    private $token;

    public function __construct()
    {
        if (isset($_SESSION['token'])) {
        }

        $this->_db = new DB();
    }
    
    public function CreateToken($uid)
    {
        $time = time();
        // 生成Token
        $token = base64_encode(json_encode(array('uid' => $uid, 'time' => $time)));
        // 保存Token
        $this->_db->table('sk_user')->insert(array('token' => $token));
        $this->token = $token;
        $_SESSION['token'] = $token;
        return $token;
    }

    public function info($uid)
    {
        return $this->_db->table('sk_user')->where('uid = "' . $uid . '"')->select();
    }
}
