<?php

use FrameWork\Plugin\Plugin;

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
</head>

<body class="pear-container">
    <?php
    if (Plugin::$plugin_error_msg) {
        echo '<div class="layui-card"><div class="layui-card-body">';
        foreach (Plugin::$plugin_error_msg as $msg) {
            echo "<blockquote class='layui-elem-quote'>{$msg}</blockquote>";
        }
        echo '</div></div>';
    }
    ?>
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane">
                <table class="layui-table" lay-even>
                    <colgroup>
                        <col width="250">
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
                        <?php
                        if (Plugin::$plugin_config) {
                            foreach (Plugin::$plugin_config as $data) : ?>
                                <tr>
                                    <td><a <?php if (!empty($data['app']['Plugin Url'])) {
                                                echo 'href="' . $data['app']['Plugin Url'] . '"';
                                            } ?> target="_blank"><?= $data['app']['Name'] ?></a></td>
                                    <td><?= $data['app']['Version'] ?></td>
                                    <td><a <?php if (!empty($data['app']['Author Url'])) {
                                                echo 'href="' . $data['app']['Author Url'] . '"';
                                            } ?> target="_blank"><?= $data['app']['Author'] ?></a></td>
                                    <td><?= $data['app']['Description'] ?></td>
                                    <td>
                                        <?php
                                        if ($data['use']) {
                                            echo '<button type="button" class="layui-btn layui-btn-primary layui-btn-sm"  data-interdict="';
                                            echo $data['app']['Name'];
                                            echo '">禁用</button>' . PHP_EOL;
                                        } else {
                                            echo "<button type='button' class='layui-btn layui-bg-blue layui-btn-sm' data-active='";
                                            echo $data['app']['Name'];
                                            echo "'>启用</button>" . PHP_EOL;
                                        }

                                        echo '<button type="button" class="layui-btn layui-bg-red layui-btn-sm"  data-del="';
                                        echo $data['app']['Name'];
                                        echo '">删除</button>';
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