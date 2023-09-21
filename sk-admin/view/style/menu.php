<?php

use FrameWork\Main as FrameWork;
use FrameWork\View\View;
var_dump(View::getMenu())
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>数据卡片</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css"/>
</head>
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form layui-form-pane">
        <table class="layui-table" lay-even>
  <colgroup>
    <col width="200">
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>名称</th>
      <th>类型</th>
      <th>父菜单</th>
      <th>路径</th>
    </tr> 
  </thead>
  <tbody>
    <tr>
      <td>孔子</td>
      <td>华夏</td>
      <td>有朋至远方来，不亦乐乎</td>
    </tr>
    
  </tbody>
</table>

        </form>
    </div>
</div>
<script src="/sk-admin/component/layui/layui.js"></script>
<script src="/sk-admin/component/pear/pear.js"></script>
<script src="/sk-include/static/js/axios.min.js"></script>

<script>
    layui.use(['table', 'layer', 'form', 'jquery', 'card'], function () {

        let table = layui.table;
        let form = layui.form;
        let $ = layui.jquery;
        let layer = layui.layer;

    })
</script>
</body>
</html>

