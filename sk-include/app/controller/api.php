<?php

use Illuminate\Database\Capsule\Manager as DB;
use WpOrg\Requests\Requests;
use FrameWork\FrameWork;
use FrameWork\User\User;
use FrameWork\View\View;
use FrameWork\Plugin\Plugin;
use FrameWork\Captcha\Captcha;
use FrameWork\File\File;
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
                        if (isset($_GET['page'], $_GET['limit']) && is_numeric($_GET['page']) && is_numeric($_GET['limit'])) {
                            $data = array_reverse(toArray(Db::table('sk_user')->select('uid','name','mail','avatar','role','ban','logintime','ua','created')->get()));
                            // 当前页码
                            $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                            // 数据数量
                            $limit = !empty($_GET['limit']) ? $_GET['limit'] : 10;
                            // 分页
                            $data = Utils::Pager($data, $limit, $_GET['page']);
                            if ($_GET['page'] > $data['total_page'] && $_GET['page'] != 1) {
                                jsonMsg(400,'页码大于总页数');
                            } else {
                                exit(json_encode(['code' => 0, 'count' => $data['total_count'], 'data' => $data['data']]));
                            }
                        } else {
                            jsonMsg(400,'请求无效');
                        }
                    } else {
                        jsonMsg(403, '权限不足！');
                    }
                    break;
                case 'add':
                    // 验证数据合法性
                    if (is_array(Utils::DecodeRequestData('POST', 'data'))) {
                        $data = Utils::DecodeRequestData('POST', 'data');
                    } else {
                        jsonMsg(404, '无数据');
                    }
                    // 拦截非管理员用户操作他人数据的行为
                    if (User::is_user()) {
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
                    if (isset($data['pwd'])) {
                        $data['pwd'] = User::encode_pwd($data['pwd'], time());
                    }
                    unset($data['file']);
                    // 更新数据
                    if (Db::table('sk_user')->insert(['name' => $data['name'], 'pwd' => $data['pwd'], 'mail' => $data['mail'], 'avatar' => $data['avatar'], 'role' => $data['role'], 'ban' => $data['ban'], 'created' => time()])) {
                        jsonMsg(200, '添加成功');
                    } else {
                        jsonMsg(400, '添加失败');
                    }
                    break;
                case 'token':
                    jsonMsg(200, '操作成功', ['login' => true, 'token' => $_SESSION['token']]);
                    break;
                case 'update':
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
                    if (isset($data['pwd'])) {
                        $data['pwd'] = User::encode_pwd($data['pwd'], time());
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
                case 'search':
                    if ()
                    break;
                case 'remove':
                    if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
                        try {
                            if (DB::table('sk_user')->where('uid', $_GET['uid'])->exists()) {
                                DB::table('sk_user')->where('uid', $_GET['uid'])->delete();
                                jsonMsg(200, '删除成功');
                            } else {
                                jsonMsg(400, '数据不存在');
                            }
                        } catch (Exception $e) {
                            jsonMsg(500, $e->getMessage());
                        }
                    } else {
                        jsonMsg(403, '参数错误');
                    }
                    break;
                case 'batchRemove':
                    if (User::is_admin()) {
                        if (isset($_GET['uid'])) {
                            $ids = $_GET['uid'];
                            $ids = preg_split('/,/', $ids, -1, PREG_SPLIT_NO_EMPTY);
                            try {
                                foreach ($ids as $id) {
                                    if (is_numeric($id)) {
                                        if (DB::table('sk_user')->where('uid', $_GET['uid'])->exists()) {
                                            DB::table('sk_user')->where('uid', $_GET['uid'])->delete();
                                        }
                                    }
                                }
                                jsonMsg(200, '删除成功');
                            } catch (Exception $e) {
                                jsonMsg(500, $e->getMessage());
                            }
                        } else {
                            jsonMsg(403, '参数错误');
                        }
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
                    header('Content-type:image/webp');
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
        $file_type = [
            'image' => [
                'image/png',
                'image/jpg',
                'image/webp',
                'image/jpeg'
            ]
        ];
        $upload_type = [
            'avatar' => ['avatar', CON . 'upload/avatar/']
        ];
        // 请求参数验证
        if (isset($_GET['file'], $_GET['type'], $_FILES['file'])) {
            try {
                $data = $_FILES['file'];
                // 文件类型验证
                for ($i = 0; $i < count($file_type[$_GET['file']]); $i++) {
                    $this->type = $this->type + 1;
                }
                if ($this->type == 4 && isset($upload_type[$_GET['type']])) {
                    // 存储文件
                    $dir = $upload_type[$_GET['type']][1] . $_FILES["file"]["name"];
                    $data = File::Upload($_FILES["file"]["tmp_name"], $dir);
                    if ($data['code'] == 200) {
                        jsonMsg($data['code'], $data['msg'], ['url' => $data['data']['url']]);
                    } else {
                        jsonMsg(500, '上传失败');
                    }
                } else {
                    $data = ['code' => 400, 'msg' => "不支持{$data['type']}类型的文件"];
                }
            } catch (Exception $e) {
                jsonMsg(500, $e->getMessage());
            }
        } else {
            jsonMsg(403, '参数错误');
        }
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
        if (isset($_POST['action']) && isset($_POST['name']) && User::is_admin()) {
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
            jsonMsg(403, '非法请求');
        }
    }

    public function SaveSetting()
    {

        if (isset($_POST['data']) && User::is_admin()) {
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
        } else {
            jsonMsg(403, '非法请求');
        }
    }

    public function update()
    {
        $a = $this->action;
        switch ($a) {
            case 'check':
                $headers = array('Content-Type' => 'application/json');
                $arr = Requests::post(API_HOST . 'UpdateCheck', $headers, json_encode(CONFIGS));
                $arr = json_decode($arr->body, true);
                jsonMsg(200, 'success', $arr);
                break;
            case 'do':
                $url = API_HOST . 'UpdateDo';
                $save_path = CON . 'temp/download/ ';
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
    }

    function cloud()
    {
        if (CONFIGS['App']['Mode'] == 'online') {
            if (!empty(FrameWork::getData())) {
                switch (FrameWork::getData()) {
                    case 'getNews':
                        $headers = array('Content - Type' => 'application / json');
                        $arr = Requests::post(API_HOST . 'getNews', $headers, json_encode(CONFIGS));
                        echo json_encode(json_decode($arr->body, true));
                        break;
                    default:
                        jsonMsg(400, '非法请求');
                        break;
                }
            } else {
                jsonMsg(403, '非法请求');
            }
        } else {
            jsonMsg(400, '您已开启【离线模式】无法进行与【云端】相关的操作');
        }
    }
}
