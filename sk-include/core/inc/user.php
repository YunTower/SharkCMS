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

namespace FrameWork\User;

use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\FrameWork;

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
        if (APP_INSTALL) {
            // 验证登陆状态
            if (isset($_SESSION['token'])) {
                $info = toArray(DB::table('sk_user')->where('token', $_SESSION['token'])->get());
                // 验证token真实性
                if (isset($info)) {
                    if (count($info) == 1) {
                        User::$loginStatus = true;
                        User::$userInfo = $info[0];
                        User::$userRole = $info[0]['role'];
                        if (static::is_ban()) {
                            FrameWork::WARNING(0, ['系统提示', '您的账号已被【禁用】，请联系网站管理员！']);
                        }
                    } else {
                        User::LoginOut();
                        FrameWork::WARNING(0, ['系统提示', '账号数据异常，请刷新此页面后重新登陆']);
                    }
                }
            }
        }
    }

    public static function is_login()
    {
        if (static::$loginStatus) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_admin()
    {
        if (static::$loginStatus) {
            if (static::$userRole == 'admin') {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function is_user()
    {
        if (static::$loginStatus) {
            if (static::$userRole == 'user') {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function is_ban()
    {
        if (static::$loginStatus) {
            if (static::$userInfo['ban'] == 1) {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function CreateToken($id)
    {
        $time = time();
        // 生成Token
        $token = base64_encode(json_encode(array('uid' => $id, 'time' => $time)));
        // 保存Token
        Db::table('sk_user')->where('uid', $id)->update(array('logintime' => time(), 'token' => $token));
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function getInfo($uid = null)
    {
        if ($uid == null) {
            if (User::$loginStatus) {
                $id = User::$userInfo['uid'];
            } else {
                return false;
            }
        }
        return toArray(Db::table('sk_user')->where('uid', $uid)->first());
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
