<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.cn
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */


# --------------------------------## 主题组件 ##--------------------------------#
class View extends FrameWork
{
    public static $sTitle;
    public static $vArticle;
    public static $vName;
    public static $vUrl;
    public static $vKey;
    public static $vTheme = array();
    public static $vConfig = array();

    public function __construct()
    {
        // 主题名称
        self::$vName = self::$_db->table('sk_setting')->where('name = "theme-name"')->select()['value'];

        // 当前主题路径
        self::$vUrl = CON . 'theme/' . self::$vName . '/';

        // 扫描目录
        $dir = scandir(CON . 'theme/');
        unset($dir[0]);
        unset($dir[1]);
        $dir = array_values($dir);

        // 生成路径
        foreach ($dir as $d) {
            $url = CON . 'theme/' . $d;
            $url = array($d => $url);
            self::$vTheme = self::$vTheme + $url;
        }

        // 读取配置
        foreach (self::$vTheme as $k => $v) {
            if (is_dir($v)) {
                $c = $v . '/theme.php';
                if (file_exists($c)) {
                    $b = include_once $v . '/theme.php';
                    self::$vConfig = self::$vConfig + array($k => $b);
                }
            }
        }
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
        echo '<!-- Powered by SharkCMS v' . self::$_App['app']['Version'] . ' -->' . PHP_EOL;
        // 主题自定义函数
        include_once self::$vUrl . 'inc/function.php';
        // 主题自定义路由
        include_once self::$vUrl . 'inc/route.php';
        // 主题页面文件
        include_once self::$vUrl . 'page/' . $page . '.php';
    }

    // pjax
    public static function pjax($file)
    {
        echo file_get_contents(ADM . $file);
    }

    public static function static($file)
    {
        echo self::getDomain() . '/sk-content/theme/' . self::$vName . '/' . $file;
    }

    // 文件加载
    public static function include($file)
    {
        include_once self::$vUrl . $file;
    }

    // 加载头部文件
    public static function get_header()
    {
        include self::$vUrl . 'header.php';
    }

    // 加载边栏
    public static function get_sidebar()
    {
        $f = self::$vUrl . 'sidebar.php';
        if (file_exists($f)) {
            include $f;
        } else {
            self::Error('系统错误', '主题文件【sidebar.php】不存在');
        }
    }

    // 加载底部文件
    public static function get_footer()
    {
        include self::$vUrl . 'footer.php';
    }

    // 查询主题设置
    public static function vSet($name)
    {
        echo self::$_db->table('sk_theme')->where("name = '$name'")->select()['value'];
    }

    // 列表查询
    public static function query($a)
    {
        switch ($a) {
            case 'article':
                return self::$_db->table('sk_content')->select();
                break;
            case 'tag':
                $key = self::$vKey;
                $cid = self::$_db->table('sk_tag')->where("name = '$key'")->select()['cid'];
                return array(self::$_db->table('sk_content')->where('cid = ' . $cid)->select());
            case 'category':
                $key = self::$vKey;
                $cid = self::$_db->table('sk_category')->where("name = '$key'")->select()['cid'];
                return array(self::$_db->table('sk_content')->where('cid = ' . $cid)->select());
            default:
                self::Error('Error', '在调用模板方法时产生错误【View::query】，没有方法【' . $a . '】');
                break;
        }
    }


    /**
     * 数据库分页
     * [$table](数据表)
     * [pSize](每页显示数量)
     * [$pCount](页码)
     */
    public static function QueryPage($table, $pSize = 15, $pCount = 1)
    {
        $data = self::$_db->getAll($table);
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
}
