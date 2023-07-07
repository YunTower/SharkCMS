<?php
class index extends FrameWork
{
    private $data;
    private $theme;
    private $arr = array();
    private $config = array();

    function __construct()
    {
        // self::$_ = self::$_db->table('sk_setting')->where('name = "theme-name"')->select()['value'];
    }

    public function index()
    {
        self::$_view::view('home');
    }
    

}
