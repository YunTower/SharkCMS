<?php
class admin{
    function __construct()
    {
    }

    function login(){
        echo '登陆';
    }

    function index(){
        header('Location: /admin/login');
    }
    
    function admin(){
        echo '页面正常';
    }
}