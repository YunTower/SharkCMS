<?php
class api extends FrameWork
{
    private $data;
    private $info;
    private $action;
    private $eDate = array();

    function __construct()
    {
        // 初始化
        header('Content-Type: application/json; charset=utf-8');
        $data = file_get_contents("php://input");
        $data = base64_decode($data);
        $data = json_decode($data, true);
        $this->data = $data;

        $this->action = FrameWork::getData();

        // 接口权限验证
        if ($this->action == 'avatar' || 'upload' || 'file' || 'get' || 'post') {
            // 验证token是否存在
            if (isset($_SESSION['token'])) {
                // 解码token
                $_token = (json_decode(base64_decode($_SESSION['token'])));
                // 获取用户信息
                $_uid = $_token->uid;
                // 查询用户信息
                $this->info = self::$_db->table('sk_user')->where('uid =' . $_uid)->select();
                // 验证用户组
                if (!$this->info) {
                    exit(json_encode(array('code' => 500, 'msg' => '非真实用户!用户信息不存在!', 'error' => null)));
                }
            }
        }
    }

    // 登陆接口
    function login()
    {
        $data = $this->data;
        $user = self::$_db->table('sk_user')->where('mail =  "' . $data['umail'] . '"')->select();

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
                            if ($user['group'] == 'admin') {
                                // 生成Token
                                self::$_user->CreateToken($user['uid']);
                                // 返回成功信息
                                echo json_encode(array('code' => 200, 'msg' => '登陆成功'));
                            } else {
                                echo json_encode(array('code' => 403, 'msg' => '【权限组】不是管理员'));
                            }
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

    function loginOut()
    {
        unset($_SESSION['token']);
        exit(json_encode(array('code' => 200, 'msg' => '操作成功', 'error' => null)));
    }

    // // 文件操作
    // function file()
    // {
    //     switch ($this->action) {
    //         case 'list':
    //             $file = File::List(CON . 'upload');
    //             $msg = '查询成功';
    //             if (!$file) {
    //                 $msg = '没有文件或文件不存在';
    //             }
    //             exit(json_encode(array('code' => 0, 'msg' => $msg, 'error' => null, 'data' => $file)));
    //             break;
    //         default:
    //             exit(json_encode(array('code' => 1000,)));
    //             break;
    //     }
    // }

    // 列表输出
    public function get()
    {

        switch ($this->action) {
            case 'post':
                exit(json_encode(array('code' => 0, 'count' => 1, 'msg' => '查询成功', 'data' => self::$_db->getAll('sk_content'))));
                break;
            case 'news':

            default:
                exit(json_encode(array('code' => 400,)));
                break;
        }
    }

    // 输出头像
    function avatar()
    {
        if (is_numeric($this->action)) {
            $data = self::$_db->table('sk_user')->where('uid = ' . $this->action)->select();
            header('Content-type: image/webp');
            if ($data['avatar']) {
                include $data['avatar'];
            } else {
                include CON . 'upload/avatar/default.webp';
            }
        } else {
            exit(json_encode(array('code' => 403, 'msg' => 'uid 格式不正确!', 'error' => null)));
        }
    }


    // 文章操作
    function post()
    {
        switch ($this->action) {
            case 'save':
                $data = $this->data;
                $sql = self::$_db->table('sk_content')->insert(array('title' => $data['title'], 'slug' => $data['slug'], 'content' => $data['post'], 'cover' => $data['cover'], 'pwd' => $data['pwd'], 'uid' => $this->info['uid'], 'uname' => $this->info['name']));
                if ($sql) {
                    exit(json_encode(array('code' => 200, 'msg' => '操作成功', 'error' => null)));
                } else {
                    exit(json_encode(array('code' => 500, 'msg' => '操作失败', 'error' => self::$_db->error()['error'])));
                }

                break;
            default:
                exit(json_encode(array('code' => 500, 'msg' => '操作失败', 'error' => null)));
                break;
        }
    }

    // 文件上传
    function upload()
    {
        switch ($this->action) {
            case 'cover':
                $file = CON . "upload/cover/" . $_FILES["file"]["name"];
                echo filesize($file);
                if (file_exists($file)) {
                    exit(json_encode(array('code' => 400, 'msg' => '文件已存在', 'error' => null, 'data' => $file)));
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $file);
                    exit(json_encode(array('code' => 200, 'msg' => '文件上传成功', 'error' => null, 'data' => $file)));
                }

                break;

            case 'video':

            default:
                exit(json_encode(array('code' => 400, 'msg' => '操作失败', 'error' => null)));
                break;
        }
    }
}
