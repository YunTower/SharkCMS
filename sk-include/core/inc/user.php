<?php

namespace FrameWork\User;

use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\Main as FrameWork;

class User
{
    // 登陆状态
    public static $loginStatus = false;
    // 用户角色
    public static $userRole;
    // 用户信息
    public static $userInfo;

    public static function init()
    {
        if (FrameWork::inStatus()) {
            @$token = $_SESSION['token'];
            // 验证登陆状态
            if (isset($token)) {
                $info = toArray(DB::table('sk_user')->where('token', "$token")->get());
                // 验证token真实性
                if (isset($info)) {
                    if (count($info) == 1) {
                        User::$loginStatus = true;
                        User::$userInfo = $info[0];
                        User::$userRole = $info[0]['role'];
                    } else {
                        FrameWork::Error(0, ['系统错误', '账号数据异常']);
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
        Db::table('sk_user')->where('uid', $id)->update(array('token' => $token));
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function info($id)
    {
        return toArray(Db::table('sk_user')->where('uid = "' . $id . '"')->first());
    }

    public static function LoginOut()
    {
        if (User::$loginStatus) {
            try {
                unset($_SESSION['token']);
                $id = User::$userInfo['uid'];
                Db::table('sk_user')->where('uid', $id)->update(['token' => null]);
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return false;
        }
    }

    public static function encode_pwd($pwd, $t)
    {
        return md5(md5($pwd) . $t);
    }
}
