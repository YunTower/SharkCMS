<?php

use FrameWork\Main as FrameWork;
use FrameWork\View\View;

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
</head>

<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane">
                <table class="layui-table" lay-even>
                    <colgroup>
                        <col width="200">
                        <col width="100">
                        <col width="100">
                        <col>
                        <col width="150">

                    </colgroup>
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>版本</th>
                            <th>作者</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>默认插件</td>
                            <td>1.0</td>
                            <td>fish</td>
                            <td>这是一个SharkCMS自带的插件模板，它会在后台显示一些小贴士，你可以基于它开发一个插件。</td>
                            <td>
                                <button type="button" class="layui-btn layui-btn-primary layui-btn-sm">启用</button>
                                <button type="button" class="layui-btn layui-bg-red layui-btn-sm">删除</button>

                            </td>

                        </tr>

                    </tbody>
                </table>
            </form>
            <div id="currentTableId"></div>
        </div>
    </div>
    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>

    <script>
        layui.use(['table', 'layer', 'form', 'jquery'], function() {


        })
    </script>
</body>

</html>