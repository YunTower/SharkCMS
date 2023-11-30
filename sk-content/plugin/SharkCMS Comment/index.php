<?php

use FrameWork\Hook\Hook;
use FrameWork\Plugin\Plugin;

class SCMSCPlugin
{
    function __construct()
    {
        Hook::do('theme-header', $this, 'static_css');
        Hook::do('theme-footer', $this, 'static_js');
        Hook::do('theme-comment', $this, 'comment');
    }

    function static_css()
    {
        Plugin::Static('css', 'SharkCMS Comment Plugin', 'static/sharkcms.comment.css');
    }

    function static_js()
    {
        Plugin::Static('js', 'SharkCMS Comment Plugin', 'static/sharkcms.comment.js');
    }

    function comment()
    {
        Plugin::import('SharkCMS Comment Plugin', 'comment.php');
    }


}