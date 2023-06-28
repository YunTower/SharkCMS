<?php
class index extends Controller
{
    private $data;
    private $theme;
    private $_db;
    private $_user;

    function __construct()
    {
        parent::__construct();
        $this->_db = new DB();
        $this->_user = new USER();
        $this->theme = $this->_db->table('sk_setting')->where('name = "theme-name"')->select()['value'];
    }

    public function index()
    {
        include CON . 'theme/' . $this->theme . '/index.php';
    }
}
