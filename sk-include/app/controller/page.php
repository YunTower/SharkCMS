<?php
use Illuminate\Database\Capsule\Manager as DB;


class Page extends FrameWork
{

    public function __construct()
    {
        View::$vKey = htmlspecialchars(self::getData());

    }


    public function article()
    {

        $id = View::$vKey;
        if (is_numeric($id)) {
            View::$vArticle = toArray(Db::table('sk_content')->where('cid',$id)->get())[0];

            self::$_view::view('article');
        } else {
            FrameWork::Error(404);
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

    public function  info(){
        echo $_SERVER['upload_max_filesize'];

        echo phpinfo();
    }
}
