<?php
class theme extends Controller
{
    function __construct()
    {
        // echo '非法访问';
    }

    function static(){
        // include
        $request_uri = $_SERVER['REQUEST_URI'];
        // echo 
        include CON.'theme/default/'.str_replace('/theme/', '', $request_uri);
    }
}