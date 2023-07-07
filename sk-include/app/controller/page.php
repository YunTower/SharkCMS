<?php
class Page extends FrameWork
{

    public function __construct()
    {
        View::$vKey = htmlspecialchars(self::getData());
        if (View::$vKey == null){
            self::Error('系统错误', '缺少必要的参数');
        }
    }

    public function article()
    {
        $id = View::$vKey;
        if (is_numeric($id)) {
            View::$vArticle = self::$_db->table('sk_content')->where('cid = ' . $id)->select();
            self::$_view::view('article');
        } else {
            self::Error('系统错误', '【文章id】只允许填写数字');
        }
    }

    public function category()
    {
        $id = View::$vKey;
        self::$_view::view('category');
    }

    public function tag()
    {
        $id = View::$vKey;
        self::$_view::view('tag');
    }
}
