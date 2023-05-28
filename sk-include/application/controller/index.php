<?php
class index extends Controller
{
    private $data;

    function __construct()
    {
        parent::__construct();
        $this->data=array(
            'img_logo'=>'theme/static/img/logo.jpg'
        );
    }

    function index()
    {
        $this->view('default/index', $this->data);
    }
}
