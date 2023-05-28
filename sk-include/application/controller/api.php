<?php
class api extends Controller
{
    function __construct()
    {
        // 权限验证
    }

    function cloud()
    {
        // $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                // 'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents('http://127.0.0.1:888', false, $context);
        echo $result;
    }

    function login()
    {
        echo '登陆接口';
    }
}
