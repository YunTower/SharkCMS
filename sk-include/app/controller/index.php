<?php
class index extends FrameWork
{
    private $data;
    private $theme;

    function __construct()
    {
        self::$_theme = self::$_db->table('sk_setting')->where('name = "theme-name"')->select()['value'];
    }

    public function index()
    {
        self::setConfig(array('db'=>array('Host'=>'a')));
        var_dump(self::$_App);
        
    }
}
