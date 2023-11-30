<?php

use FrameWork\Hook\Hook;

/**
 * 这是一个Hello World简单插件的实现
 */

class DefaultPlugin
{
    function __construct()
    {
        Hook::do('admin-top-left', $this, 'hello');
    }

    function hello()
    {
        echo '<li class="layui-nav-item"><a>Hello World</a></li>';
    }


}