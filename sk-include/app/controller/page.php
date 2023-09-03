<?php

use Illuminate\Database\Capsule\Manager as DB;
use FrameWork\Main as FrameWork;
use FrameWork\View\View;

class Page
{

    public function __construct()
    {
        View::$vKey = htmlentities(htmlspecialchars(FrameWork::getData()));
    }


    public function article()
    {

        $id = View::$vKey;
        if (is_numeric(htmlentities($id))) {
            View::$vArticle = toArray(Db::table('sk_content')->where('cid', $id)->get())[0];
            View::view('article');
        } else {
            FrameWork::Error(404);
        }
    }

    public function category()
    {
        $id = View::$vKey;
        View::view('category');
    }

    public function tag()
    {
        $id = View::$vKey;
        View::view('tag');
    }

    public function info()
    {
        echo $_SERVER['upload_max_filesize'];

        echo phpinfo();
    }
}
