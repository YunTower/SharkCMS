<?php

use FrameWork\Page;
use FrameWork\Plugin\Plugin;
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
                <?php var_dump(Page::getPageList()); ?>
                <table class="layui-table" lay-even>
                    <colgroup>
                        <col width="50">
                        <col width="100">
                        <col width="100">
                        <col width="50">
                        <col width="50">
                        
                        <col width="150">

                    </colgroup>
                    <thead>
                        <tr>
                            <th>PID</th>
                            <th>路径</th>
                            <th>标题</th>
                            <th>状态</th>
                            <th>评论</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (Page::getPageList()) {
                            foreach (Page::getPageList() as $data) : ?>
                                <tr>
                                    <td><?= $data['pid'] ?></td>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['title'] ?></td>
                                    <td>
                                        <?php if ($data['status']==1) {
                                            echo '启用';
                                        } else {
                                            echo '禁用';
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($data['allowComment']==1) {
                                            echo '启用';
                                        } else {
                                            echo '禁用';
                                        } ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($data['status']) {
                                            echo '<button type="button" class="layui-btn layui-btn-primary layui-btn-sm">禁用</button>' . PHP_EOL;
                                        } else {
                                            echo "<button type='button' class='layui-btn layui-bg-blue layui-btn-sm'>启用</button>" . PHP_EOL;
                                        }

                                        echo '<button type="button" class="layui-btn layui-bg-red layui-btn-sm">编辑</button>';
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        } else {
                            echo '<tr><td colspan="10" align="center">暂无数据</td></tr>';
                        }
                        ?>

                    </tbody>
                </table>
            </form>
            <div id="currentTableId"></div>
        </div>
    </div>
    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        layui.use(['layer', 'form', 'jquery'], function() {
            var layer = layui.layer;

            document.addEventListener('click', function(event) {

                if (event.srcElement.attributes[2] != null) {
                    axios.interceptors.request.use(config => {
                        if (config.method === 'post') {
                            config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
                        }
                        return config;
                    });

                    var nodeName = event.srcElement.attributes[2].nodeName;
                    var nodeValue = event.srcElement.attributes[2].nodeValue

                    if (nodeName == 'data-active') {
                        axios.post('/api/plugin', {
                                action: 'active',
                                name: nodeValue
                            })
                            .then(function(res) {
                                if (res.data.code == 200) {
                                    layer.msg(res.data.msg, {
                                        icon: 1
                                    });
                                    sk.sleep(1000).then(() => {
                                        parent.layui.admin.refreshThis()
                                    })

                                } else {
                                    layer.msg(res.data.msg, {
                                        icon: 2
                                    });
                                }
                            })
                    } else if (nodeName == 'data-interdict') {
                        axios.post('/api/plugin', {
                                action: 'interdict',
                                name: nodeValue
                            })
                            .then(function(res) {
                                if (res.data.code == 200) {
                                    layer.msg(res.data.msg, {
                                        icon: 1
                                    });
                                    sk.sleep(1000).then(() => {
                                        parent.layui.admin.refreshThis()
                                    })

                                } else {
                                    layer.msg(res.data.msg, {
                                        icon: 2
                                    });
                                }
                            })
                    } else if (nodeName == 'data-del') {
                        axios.post('/api/plugin', {
                                action: 'del',
                                name: nodeValue
                            })
                            .then(function(res) {
                                if (res.data.code == 200) {
                                    layer.msg(res.data.msg, {
                                        icon: 1
                                    });
                                    sk.sleep(1000).then(() => {
                                        parent.layui.admin.refreshThis()
                                    })

                                } else {
                                    layer.msg(res.data.msg, {
                                        icon: 2
                                    });
                                }
                            })
                    }
                }
            });
        })
    </script>
</body>

</html>