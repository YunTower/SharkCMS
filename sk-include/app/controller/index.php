<?php

class Index extends FrameWork
{
    private $data;
    private $theme;
    private $arr = array();
    private $config = array();

    function __construct()
    {

        // 获取页码
        $pid = self::getAction();

        // 默认第一页
        if (!isset($pid) || $pid == 'index') {
            $pid = 1;
        }

        // 设置标题
        if ($pid == 1) {
            View::$sTitle = "首页";
        } else {
            View::$sTitle = "第{$pid}页";
        }

        // 404
        if (!is_numeric($pid)) {
            FrameWork::Error(404);
        }

        // 分页
        $data = View::Pager(View::query('article'), 10, $pid);

        // 加载页面模板
        View::$vArticle = $data;
        self::$_view::view('home');
    }


}
