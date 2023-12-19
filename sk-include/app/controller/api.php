<?php

use Illuminate\Database\Capsule\Manager as DB;
use WpOrg\Requests\Requests;
use FrameWork\FrameWork;
use FrameWork\User\User;
use FrameWork\View\View;
use FrameWork\Plugin\Plugin;
use FrameWork\Captcha\Captcha;
use FrameWork\Utils;

class Api extends FrameWork
{
    private $data;
    private $action;
    private $eDate = array();
    private $type;
    private $SettingArr = [];
    private $theme_array = [];

    function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');
        // 请求频率控制
        if (isset($_SESSION['ban']) && $_SESSION['ban'] == true) {
            // 获取起始时间
            $ban_start = $_SESSION['ban_start'];
            // 获取当前时间戳
            $now = time();
            // 剩余封禁时间（秒）
            $t = 600 - ($now - $ban_start);
            // 剩余时间大于600秒
            if ($t >= 0) {
                exit(json_encode(['code' => 403, 'msg' => "请求过于频繁，请在【{$t}秒】后重试"]));
            } else {
                // 取消封禁
                unset($_SESSION['count']);
                unset($_SESSION['require_start']);
                unset($_SESSION['ban']);
                unset($_SESSION['ban_start']);
            }
        } else {
            // 频率记录
            if (isset($_SESSION['count'])) {
                $start = $_SESSION['require_start'];
                $now = time();
                // 30秒内请求大于等于20次
                if ($now - $start <= 30 && $_SESSION['count'] >= 20) {
                    $_SESSION['ban'] = true;
                    $_SESSION['ban_start'] = time();
                    exit(json_encode(['code' => 403, 'msg' => '请求过于频繁，请在600秒后重试']));
                }
                // 次数+1
                $_SESSION['count'] = $_SESSION['count'] + 1;
            } else {
                // 设置初始次数和开始时间
                $_SESSION['count'] = 1;
                $_SESSION['require_start'] = time();
            }
        }

        // 初始化请求
        $data = file_get_contents("php://input");
        $data = base64_decode($data);
        $data = json_decode($data, true);
        $this->data = $data;
        $this->action = FrameWork::getData();
        // 接口权限验证
        if (FrameWork::getAction() != 'login' && FrameWork::getAction() != 'captcha') {
            if (!User::$loginStatus) {
                exit(json_encode(['code' => 403, 'msg' => '权限不足！', 'data' => ['login' => false]]));
            }
        }
    }

    function captcha()
    {
        Captcha::get();
    }


    function user()
    {
        if (User::$loginStatus) {
            switch ($this->action) {
                case 'get':
                    if (User::is_admin()) {
                        jsonMsg(0, '数据拉取成功', toArray(Db::table('sk_user')->select('uid', 'name', 'mail', 'avatar', 'ban', 'role', 'created')->get()));
                    } else {
                        jsonMsg(403, '权限不足！');
                    }
                    break;
                case 'token':
                    jsonMsg(200, '操作成功', ['login' => true, 'token' => $_SESSION['token']]);
                    break;
                case'update':
                    // 验证数据合法性
                    if (is_array(Utils::DecodeRequestData('POST', 'data'))) {
                        $data = Utils::DecodeRequestData('POST', 'data');
                    } else {
                        jsonMsg(404, '无数据');
                    }
                    // 拦截非管理员用户操作他人数据的行为
                    if (!isset($_GET['uid']) && is_numeric(htmlspecialchars($_GET['uid'])) || User::is_user() && htmlspecialchars($_GET['uid']) != User::$userInfo['uid']) {
                        jsonMsg(403, '权限不足！');
                    }
                    // 转换数据
                    if (isset($data['ban'])) {
                        if ($data['ban'] == 'true') {
                            $data['ban'] = true;
                        } else if ($data['ban'] == 'false') {
                            $data['ban'] = false;
                        }
                    }
                    // 处理密码
                if (isset($data['pwd'])){
                    $data['pwd']=User::encode_pwd($data['pwd'],time());
                }
                    // 拦截站长的作死行为
                    if ($data['ban'] == true && $_GET['uid'] == 1 || $data['role'] == 'user' && $_GET['uid']) {
                        jsonMsg(400, '此操作已被阻止，请不要作死');
                    }
                    unset($data['file']);
                    // 更新数据
                    if (Db::table('sk_user')->where('uid', htmlspecialchars($_GET['uid']))->update($data)) {
                        jsonMsg(200, '更新成功');
                    } else {
                        jsonMsg(400, '更新失败');
                    }

                    break;
                default:
                    jsonMsg(403, '权限不足！');
                    break;
            }
        } else {
            jsonMsg('403', '权限不足！');
        }
    }


    // 输出头像
    function avatar()
    {
        if (is_numeric($this->action)) {
            $data = self::$_db->table('sk_user')->where('uid = ' . $this->action)->find();
            if (!empty($data['avatar'])) {
                $file = self::getDomain() . $data['avatar'];
                if (file_exists($file)) {
                    header('Content - type: image / webp');
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
                $arr = ['cid' => $data['cid'], 'type' => $data['type'], 'content' => $data['content'], 'uid' => User::$userInfo['uid'], 'status' => null, 'parent' => 0];
                $db = DB::table('sk_comment')->insert($arr);
                if ($db) {
                    exit(json_encode(['code' => 200, 'msg' => '评论成功', 'data' => ['status' => true, 'login' => true]]));
                } else {
                    exit(json_encode(['code' => 500, 'msg' => '评论失败', 'data' => ['status' => false, 'login' => true]]));
                }
                break;
            case 'update':
                break;
            case 'get':
                break;
            default:
                exit(json_encode(['code' => 400, 'msg' => '无效的请求', 'data' => []]));
                break;
        }
    }


    // 文章操作
    function article()
    {
        switch ($this->action) {
            case 'save':
                $data = $_POST['data'];
                if (is_array($data) && !empty($data['title']) && !empty($data['slug']) && !empty($data['content'])) {

                    $info = User::$userInfo;
                    $sql = self::$_db->table('sk_content')->insert(array('title' => $data['title'], 'slug' => $data['slug'], 'content' => $data['content'], 'cover' => $data['cover'], 'pwd' => $data['pwd'], 'uid' => $info['uid'], 'uname' => $info['name']));
                    if ($sql) {
                        exit(json_encode(array('code' => 200, 'msg' => '操作成功', 'error' => null)));
                    } else {
                        exit(json_encode(array('code' => 500, 'msg' => '操作失败', 'error' => self::$_db->error()['error'])));
                    }
                } else {

                }

                break;
            case 'get':
                exit(json_encode(['code' => 0, 'msg' => '操作成功', 'data' => View::$vArticle, 'count' => count(View::$vArticle)]));
            default:
                exit(json_encode(array('code' => 500, 'msg' => '操作失败', 'error' => null)));
                break;
        }
        return exit(json_encode($res));
    }

    // 文件上传
    public function upload()
    {
        $type_img = [
            'image/png',
            'image/jpg',
            'image/webp',
            'image/jpeg'
        ];
        if (isset($_FILES['file'])) {
            switch ($this->action) {
                case 'Cover':
                    try {
                        $data = $_FILES['file'];
                        // 类型验证
                        for ($i = 0; $i < count($type_img); $i++) {
                            $this->type = $this->type + 1;
                        }
                        if ($this->type == 4) {
                            // 存储文件
                            $dir = CON . "upload/avatar/" . $_FILES["file"]["name"];
                            $data = File::Upload($_FILES["file"]["tmp_name"], $dir);

                        } else {
                            $data = ['code' => 400, 'msg' => "不支持{$data['type']}类型的文件"];
                        }
                    } catch (Exception $e) {
                        $data = ['code' => 500, 'msg' => $e->getMessage()];
                    }
                    break;
                case 'SiteIcon':

                    // 文件信息
                    $data = $_FILES['file'];
                    // 类型验证
                    for ($i = 0; $i < count($type_img); $i++) {
                        $this->type = $this->type + 1;
                    }

                    if ($this->type == 4) {
                        // 存储文件
                        $file = CON . "upload/" . $_FILES["file"]["name"];
                        move_uploaded_file($_FILES["file"]["tmp_name"], $file);
                        // 更新设置
                        DB::table('sk_setting')->where('name', 'Site - Logo')->update(['value' => FrameWork::getDomain() . '/sk-content/upload/' . $_FILES["file"]["name"]]);
                        exit(json_encode(['code' => 200, 'msg' => '上传成功', 'data' => ['url' => FrameWork::getDomain() . '/sk-content/upload/' . $_FILES["file"]["name"]]]));
                    } else {
                        exit(json_encode(['code' => 400, 'msg' => "不支持{$data['type']}类型的文件"]));
                    }
                    break;

                case 'video':

                default:
                    exit(json_encode(array('code' => 400, 'msg' => '操作失败', 'error' => null)));
                    break;
            }
        } else {
            $data = ['code' => 400, 'msg' => '文件上传失败，无效的操作'];
        }
        exit(json_encode($data));
    }

    public function getTheme()
    {

        $data = array_values(View::$vConfig);

        foreach ($data as $_data) {
            $_data = array_values($_data);
            $this->theme_array[] = ['id' => $_data[0]['Name'], 'image' => $_data[3] . 'cover . png', 'title' => $_data[0]['Name'], 'remark' => $_data[0]['Description'], 'time' => $_data[0]['Time']];
        }

        echo json_encode(['code' => 0, 'msg' => '获取成功', 'count' => count($data), 'data' => $this->theme_array]);
    }

    public function plugin()
    {
        if (isset($_POST['action']) && isset($_POST['name'])) {
            $action = $_POST['action'];
            $name = $_POST['name'];
            if ($action == 'active') {
                if (Plugin::setConfig($name, ['use' => true])) {
                    FrameWork::return_json(['code' => 200, 'msg' => '操作成功']);
                }
            } else if ($action == 'interdict') {
                if (Plugin::setConfig($name, ['use' => false])) {
                    FrameWork::return_json(['code' => 200, 'msg' => '操作成功']);
                }
            } else if ($action == 'del') {
                if (Plugin::del_plugin(Plugin::$plugin_config[$name]['path'])) {
                    FrameWork::return_json(['code' => 200, 'msg' => '操作成功']);
                }
            } else {
                FrameWork::return_json(['code' => 400, 'msg' => '操作不存在 / 操作失败']);
            }
        } else {
            FrameWork::return_json(['code' => 403, 'msg' => '参数缺失']);
        }
    }

    public function SaveSetting()
    {

        if (isset($_POST['data'])) {
            try {
                $res = $_POST['data'];
                $data = [
                    'Site-Title' => $res['Site-Title'],
                    'Site-Subtitle' => $res['Site-Subtitle'],
                    'Site-Logo' => $res['Site-Logo'],
                    'Site-HeaderCode' => $res['Site-HeaderCode'],
                    'Site-FooterCode' => $res['Site-FooterCode'],
                    'Article-PageSize' => $res['Article-PageSize'],
                    'Article-AllowComment' => !empty($res['Article-AllowComment']) ? $res['Article-AllowComment'] : null,
                    'User-AllowReg' => !empty($res['User-AllowReg']) ? $res['User-AllowReg'] : null,
                    'Comment-Examined' => !empty($res['Comment-Examined']) ? $res['Comment-Examined'] : null,
                    'Comment-PostLoginComments' => !empty($res['Comment-PostLoginComments']) ? $res['Comment-PostLoginComments'] : null,
                    'Comment-PSize' => $res['Comment-PSize'],
                    'Seo-Keyword' => $res['Seo-Keyword'],
                    'Seo-Description' => $res['Seo-Description']
                ];
                foreach ($data as $key => $value) {
                    DB::table('sk_setting')->where('name', $key)->update(['name' => $key, 'value' => $value]);
                }
                exit(json_encode(['code' => 200, 'msg' => '设置保存成功']));
            } catch (Exception $e) {
                exit(json_encode(['code' => 500, 'msg' => '保存设置时发生错误：' . $e->getMessage()]));
            }
        }
    }

    public function update()
    {

        $a = $this->action;
        switch ($a) {
            case 'check':
                exit(json_encode(self::$_http->post('UpdateCheck', include_once CONFIG_FILE, 'json')));
                break;
            case 'do':
                $url = API_HOST . 'UpdateDo';
                $save_path = CON . 'temp / download / ';
                if (!file_exists($save_path)) {
                    mkdir($save_path, 0777, true); //创建目录
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //对于https的不验证ssl证书
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(include_once CONFIG_FILE));
                $resource = curl_exec($ch);
                if ($resource === FALSE) {
                    echo "CURL Error:" . curl_error($ch);
                    return false;
                }
                curl_close($ch);
                $filename = 'update . zip';
                $file = fopen($save_path . $filename, 'w + ');
                fwrite($file, $resource);
                fclose($file);

                if (file_exists($save_path . 'update . zip')) {
                    $zip = new ZipArchive;
                    if ($zip->open(CON . 'temp / download / update . zip') === true) {
                        $zip->extractTo(ROOT);
                        $zip->close();
                        exit(json_encode(['code' => 200, 'msg' => '更新成功']));
                    } else {
                        exit(json_encode(['code' => 500, 'msg' => '更新失败，请重试']));
                    }
                } else {
                    exit(json_encode(['code' => 500, 'msg' => '更新包下载失败']));
                }
                break;
            default:
                exit(json_encode(array('code' => 400, 'msg' => '操作失败', 'error' => null)));
                break;
        }
    }

    public function getNews()
    {
        $headers = array('Content - Type' => 'application / json');
        $arr = Requests::post(API_HOST . 'getNews', $headers, json_encode(CONFIGS));
        echo json_encode(json_decode($arr->body, true));
    }
}
