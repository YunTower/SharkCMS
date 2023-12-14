<?php

use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\FrameWork;
use FrameWork\Utils;
use FrameWork\User\User;

class Admin
{
    private $info;
    private $session;

    public function __construct()
    {
        // 登陆状态检测
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && FrameWork::getAction()!='loginOut') {
            // 登录
            if (User::$loginStatus) {
                // 加载后台首页
                $this->info = User::$userInfo;
                if (FrameWork::getAction() != 'view') {
                    include_once ADM . 'index.php';
                }
                // 未登录
            } else {
                // 加载登录页面
                if (FrameWork::getAction() != 'reg') {
                    // 若来源于文章
                    if (isset(explode('/', FrameWork::getOrigin())[4]) && explode('/', FrameWork::getOrigin())[4] == 'article') {
                        FrameWork::$_data = json_encode(['from' => 'article']);
                    }
                    include_once ADM . 'login.php';
                    exit();
                }
            }
        }
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            include_once ADM . 'index.php';
        } else {
            // 登陆接口
            ob_clean();
            $data = Utils::DecodeRequestData('POST','data');
            if (!isset($data)) {
                exit(json_encode(['code' => 403, 'msg' => '请求被拒绝']));
            }
            $user = toArray(Db::table('sk_user')->where('mail', $data['umail'])->get())[0];

            // 没有验证码
            if (isset($data['captcha'])) {
                // 验证码错误
                if ($data['captcha'] == @$_SESSION['captcha']) {
                    // 账号不存在
                    if ($user != null) {
                        // 账号已封禁
                        if ($user['ban'] == false) {
                            // 密码错误
                            if (md5(md5($data['upwd']) . $user['created']) == $user['pwd']) {
                                // 权限组 != admin
                                // if ($user['role'] == 'admin') {
                                // 生成Token
                                User::CreateToken($user['uid']);
                                // 返回成功信息
                                User::$loginStatus = true;
                                exit(json_encode(array('code' => 200, 'msg' => '登陆成功', 'data' => ['role' => $user['role'], 'status'=>User::$loginStatus])));
                                // } else {
                                //     echo json_encode(array('code' => 403, 'msg' => '【权限组】不是管理员'));
                                // }
                            } else {
                                echo json_encode(array('code' => 500, 'msg' => '【密码】错误'));
                            }
                        } else {
                            echo json_encode(array('code' => 500, 'msg' => '【账号】已封禁'));
                        }
                    } else {
                        echo json_encode(array('code' => 404, 'msg' => '【账号】不存在'));
                    }
                } else {
                    echo json_encode(array('code' => 500, 'msg' => '【验证码】错误'));
                }
            } else {
                echo json_encode(array('code' => 500, 'msg' => '请填写【验证码】'));
            }
            unset($_SESSION['captcha']);

        }
    }

    function loginOut()
    {
        ob_clean();
        if (User::$loginStatus) {
            if (User::LoginOut()) {
                exit(json_encode(array('code' => 200, 'msg' => '操作成功')));
            } else {
                exit(json_encode(['code' => 500, 'msg' => '系统异常，操作失败']));
            }
        } else {
            exit(json_encode(['code' => 403, 'msg' => '未登录']));
        }
    }

    public function reg()
    {
        include ADM . 'reg.php';
    }

    public function view()
    {
        if (isset($_GET['page'])) {
            if (file_exists(ADM . $_GET['page'])) {
                if (explode('/', $_GET['page'])[0] == 'view') {
                    include_once ADM . htmlentities($_GET['page']);
                } else {
                    include_once ADM . 'view/error/404.php';
                }
            } else {
                include_once ADM . 'view/error/404.html';
            }
        } else {
            echo 1;
        }
    }

}
