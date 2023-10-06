<?php

use FrameWork\Hook\Hook;

/**
 * 这是一个Hello World简单插件的实现
 */

class DefaultPlugin
{
    function __construct()
    {
        Hook::do('theme-comment', $this, 'hello');
    }

    function hello()
    {
        echo 'Hello World';
    }


}