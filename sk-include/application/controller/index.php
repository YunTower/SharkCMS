<?php
class index extends Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
        $this->data=array(
            'img_logo'=>'http://127.0.0.1/sk-content/theme/default/static/img/logo.jpg',
            'css_style'=>'http://127.0.0.1/sk-content/theme/default/static/css/style.css'
        );
    }

    function index()
    {
        $this->view('index', $this->data);
    }
}
