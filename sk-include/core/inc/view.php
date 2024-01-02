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

namespace FrameWork\View;

use FrameWork\Plugin\Plugin;
use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\FrameWork;
use FrameWork\Hook\Hook;

# --------------------------------## 主题组件 ##--------------------------------#

class View
{

    public static $vKey;
    public static $vTheme = array();
    public static $vConfig = array();
    public static $vTitle;
    public static $vArticle;
    public static $vComment;
    public static $_Comment = [];

    //    public static $/

    public static function init()
    {


        // 扫描目录
        $dir = scandir(CON . 'theme/');
        unset($dir[0]);
        unset($dir[1]);
        $dir = array_values($dir);

        // 生成路径
        foreach ($dir as $d) {
            $_dir = $url = CON . 'theme/' . $d;
            $url = FrameWork::getDomain() . '/sk-content/theme/' . $d . '/';
            $url = array($d => ['url' => $url, 'dir' => $_dir]);
            self::$vTheme = self::$vTheme + $url;
        }

        // 读取配置
        foreach (self::$vTheme as $k => $v) {
            if (is_dir($v['dir'])) {
                $c = $v['dir'] . '/theme.config.php';
                if (file_exists($c)) {
                    $b = include_once $v['dir'] . '/theme.config.php';
                    $b = $b + ['dir' => $v['dir'], 'url' => $v['url']];
                    self::$vConfig = self::$vConfig + array($k => $b);
                }
            }
        }
        self::$vArticle = toArray(Db::table('sk_content')->get());
        self::$vComment = toArray(Db::table('sk_comment')->get());
    }

    public static function allTheme()
    {
        return self::$vTheme;
    }

    public static function ThemeConfig()
    {
        return self::$vConfig;
    }

    public static function view($page)
    {
        echo '<!-- Powered by SharkCMS https://gitee.com/YunTower/SharkCMS -->' . PHP_EOL;
        // 主题自定义函数
        include_once vPath . 'inc/function.php';
        // 主题自定义路由
        include_once vPath . 'inc/route.php';
        // 主题页面文件
        include_once vPath . 'view/' . $page . '.php';
    }


    public static function static($file)
    {
        echo FrameWork::getDomain() . '/sk-content/theme/' . vName . '/' . $file;
    }

    // 文件加载
    public static function include(string $file)
    {
        include_once vPath . $file;
    }

    // 加载头部文件
    public static function get_header()
    {
        include_once INC . 'view/theme/header.php';
    }

    // 加载边栏
    public static function get_sidebar()
    {
        $f = vPath . 'sidebar.php';
        if (file_exists($f)) {
            include_once $f;
        } else {
            FrameWork::WARNING(404, '主题文件【sidebar.php】不存在');
        }
    }

    // 加载评论功能
    public static function get_comment()
    {
        // 如果已安装评论插件且开启评论插件
        if (isset(Plugin::$plugin_config['SharkCMS Comment Plugin']) && Plugin::$plugin_config['SharkCMS Comment Plugin']['use']) {
            // 如果未开启登陆后评论
            if (!FrameWork::$getSetting['Comment-PostLoginComments']) {
                Hook::add('theme-comment');
            } else {
                echo '<div class="sk-comment-list sk-comment-null"><ul><span class="sk-comment-null">站长已开启登陆后评论，<a href="/admin/login?from=article">请先登陆</a></span></ul></div>';
            }
        }
    }

    // 加载底部文件
    public static function get_footer()
    {
        include_once INC . 'view/theme/footer.php';
    }

    // 查询主题设置
    public static function vSet(string $key, string $name)
    {
        return toArray(Db::table('sk_theme')->where("$key", "$name")->get())[0]['value'];
    }

    public static function find(string $name, array $data)
    {
        switch ($name) {
            case 'article':
                return toArray(Db::table('sk_content')->where($data[0], $data[1])->get());
                break;
            default:
                return false;
                break;
        }
    }

    // 列表查询
    public static function query(string $a)
    {
        switch ($a) {
            case 'article':
                $data = array_reverse(toArray(Db::table('sk_content')->get()));

                break;
            case 'tag':
                $key = self::$vKey;
                $cid = toArray(Db::table('sk_tag')->where('name', "$key")->get())[0]['cid'];
                $data = toArray(Db::table('sk_content')->where('cid', $cid)->get());
                break;
            case 'category':
                $key = self::$vKey;
                $cid = toArray(Db::table('sk_category')->where('name', "$key")->get())[0]['cid'];
                $data = toArray(Db::table('sk_content')->where('cid', $cid)->get());
                break;
            default:
                self::WARNING(0, "在调用模板方法时产生错误【View::query】，没有方法【' . $a . '】'");
                break;
        }
        return $data;
    }


    public static function getComment(int $cid, string $type = 'article')
    {

        $comment = toArray(Db::table('sk_comment')->where('cid', "$cid")->where('type', "$type")->get());
        foreach ($comment as $d) {
            $uid = $d['uid'];
            $info = toArray(Db::table('sk_user')->where('uid', $uid)->get())[0];
            $arr = $d + ['user' => ['uid' => $info['uid'], 'name' => $info['name'], 'avatar' => $info['avatar']]];
            self::$_Comment[] = $arr;
        }

        return array_reverse(self::$_Comment);
    }

    public static function getMenu()
    {
        return toArray(DB::table('sk_menu')->get());
    }

    /**
     * 数据库分页
     * [$table](数据表)
     * [pSize](每页显示数量)
     * [$pCount](页码)
     */
    public static function Pager(array $data, int $pSize = 15, int $pCount = 1)
    {

        $total = count($data); // 计算数组总数
        $total_page = ceil($total / $pSize); // 计算总页数
        $offset = ($pCount - 1) * $pSize;     // 计算当前数据起始位置
        $page_arr = array_slice($data, $offset, $pSize); // 截取数据作为当前页数据
        return array(
            'data' => $page_arr,   // 分页数据
            'total_page' => $total_page, // 总页数
            'total_count' => $total,   // 总记录数
            'page_count' => $pCount,     // 当前页码
            'page_size' => $pSize   // 每页数据条目数
        );
    }


    public static function getTags()
    {
        return toArray(Db::table('sk_tag')->get());
    }

    public static function getCategories()
    {
        return toArray(Db::table('sk_category')->get());
    }
}
