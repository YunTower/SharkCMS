<?php
class api extends Controller
{
    private $data;
    private $_db;
    private $_user;

    function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = file_get_contents("php://input");
        $data = base64_decode($data);
        $data = json_decode($data, true);
        $this->data = $data;
        $this->_db = new DB();
        $this->_user = new USER();
    }

    // 登陆接口
    function login()
    {
        $data = $this->data;
        $user = $this->_db->table('sk_user')->where('mail =  "' . $data['umail'] . '"')->select();

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
                                $this->_user->CreateToken($user['uid']);
                                // 返回成功信息
                                echo json_encode(array('code' => 200, 'msg' => '登陆成功'));
                            } else {
                                echo json_encode(array('code' => 'error', 'msg' => '【权限组】不是管理员'));
                            }
                        } else {
                            echo json_encode(array('code' => 'error', 'msg' => '【密码】错误'));
                        }
                    } else {
                        echo json_encode(array('code' => 'error', 'msg' => '【账号】已封禁'));
                    }
                } else {
                    echo json_encode(array('code' => 'error', 'msg' => '【账号】不存在'));
                }
            } else {
                echo json_encode(array('code' => 'error', 'msg' => '【验证码】错误'));
            }
        } else {
            echo json_encode(array('code' => 'error', 'msg' => '请填写【验证码】'));
        }
        unset($_SESSION['captcha']);
    }

    // 后台接口
    function admin()
    {
    }

    // 文件操作
    function file()
    {
        switch (FrameWork::getData()) {
            case 'list':
                $file = File::List(CON . 'upload');
                $msg = '查询成功';
                if (!$file) {
                    $msg = '没有文件或文件不存在';
                }
                exit(json_encode(array('code' => 0, 'msg' => $msg, 'error' => null, 'data' => $file)));
                break;
            default:
                exit(json_encode(array('code' => 1000,)));
                break;
        }
    }

    // 用户信息操作
    function user()
    {
        switch (FrameWork::getData()) {
            case 'get':
                $data=$this->_db->getAll('sk_user');
                $msg='查询成功';
                if(!$data){
                    $msg='数据为空';
                }
                exit(json_encode(array('code'=>0,'msg'=>$msg,'count'=>100,'data'=>$data)));
                break;
            default:
                break;
        }
    }

    // 云端接口
    function cloud()
    {
        // $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                // 'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents('http://127.0.0.1:888', false, $context);
        echo $result;
    }
}
