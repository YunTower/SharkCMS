<?php

use FrameWork\Hook\Hook;
use FrameWork\Plugin\Plugin;

class SEOOPlugin
{
    function __construct()
    {
        Hook::do('admin-article-edit-right', $this, 'view');
    }

    function view()
    {
        Plugin::import('SharkCMS Article SEO Optimization','view.php') ;
    }


}