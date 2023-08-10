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
        if ($this->action != 'login'){
            if (isset($_SESSION['token'])){
                
            }else{
                exit(json_encode(['code'=>403,'msg'=>'权限不足！','data'=>[]]));
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
                            // if ($user['group'] == 'admin') {
                            // 生成Token
                            self::$_user->CreateToken($user['uid']);
                            // 返回成功信息
                            echo json_encode(array('code' => 200, 'msg' => '登陆成功', 'data' => ['group' => $user['group']]));
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

    function loginOut()
    {
        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
            $id = $this->info['uid'];
            self::$_db->table('sk_user')->where("uid = $id")->update(array('token' => null));
            exit(json_encode(array('code' => 200, 'msg' => '操作成功', 'error' => null)));
        } else {
            exit(json_encode(['code' => 403, 'msg' => '未登录', 'data' => []]));
        }
    }

    function user()
    {
        switch ($this->action) {
            case 'token':
                if (isset($_SESSION['token'])) {
                    exit(json_encode(['code' => 200, 'msg' => '操作成功', 'data' => ['login' => true, 'token' => $_SESSION['token']]]));
                } else {
                    exit(json_encode(['code' => 200, 'msg' => '操作成功', 'data' => ['login' => false, 'token' => null]]));
                }
                break;
            default:
                break;
        }
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


    // 输出头像
    function avatar()
    {
        if (is_numeric($this->action)) {
            $data = self::$_db->table('sk_user')->where('uid = ' . $this->action)->select();
            if (!empty($data['avatar'])) {
                $file = self::getDomain() . $data['avatar'];
                if (file_exists($file)) {
                    header('Content-type: image/webp');
                    include $file;
                }
            } else {
                exit(json_encode(['code' => 404, 'msg' => '头像文件不存在！']));
            }
        } else {
            exit(json_encode(array('code' => 403, 'msg' => '参数不合法!', 'error' => null)));
        }
    }

    function comment()
    {
        $data = $this->data;
        switch ($this->action) {
            case 'post':
                $token = $data['token'];

                    self::$_db->table('sk_comment')->insert(['']);
                break;
            default:
                break;
        }
        var_dump($this->data);
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
            case 'list':
                exit(json_encode(['code' => 0, 'msg' => '操作成功', 'data' => self::$_db->getAll('sk_content')]));
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

    public function info()
    {
        $db = self::$_db;
        $arr =
            [
                'site' =>
                [
                    'count' =>
                    [
                        'page' => $db->table('sk_page')->where('pid')->count(),
                        'post' => $db->table('sk_content')->where('cid')->count(),
                        'user' => $db->table('sk_user')->where('uid')->count(),
                        // 'menu' => $db->table('sk_menu')->where('mid')->count(),
                        // 'comment'=>$db->table('sk_comment')->where('id')->count(),
                        'category' => $db->table('sk_category')->where('id')->count(),
                        'tag' => $db->table('sk_tag')->where('id')->count()
                    ],

                    'system' =>
                    [
                        'version' => self::$_App
                    ],
                ],
            ];
        var_dump($arr);
    }

    public function update()
    {
        $a = $this->action;
        switch ($a) {
            case 'check':
                var_dump(self::$_http->post('UpdateCheck', self::$_App, 'json'));
                break;
            default:
                exit(json_encode(array('code' => 400, 'msg' => '操作失败', 'error' => null)));
                break;
        }
    }
    public function getNews()
    {
        echo json_encode(self::$_http->setTimeout(5)->post('getNews', self::$_App, 'json'));
    }
}
