<?php
header('Access-Control-Allow-Origin:*');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>后台 - SharkCMS内容管理系统</title>
    <link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet">
</head>

<body class="pear-container">
    <div class="layui-row layui-col-space10">
        <!-- 基础设置 -->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">控制面板</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <div class="pear-btn-group">
                            <button class="pear-btn" id="check">检查更新</button>
                            <button plain class="pear-btn pear-btn-primary" id="update">立即更新</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header">更新详情 <a id="update" style="color: #2d8cf0;">一键更新</a></div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <p>版本号：<a id="v">加载中</a></p>
                        <p>版本类型：<a id="t">加载中</a></p>
                        <p>更新方式：<a id="m">加载中</a></p>
                        <p>更新内容：<a id="c">加载中</a></p>
                    </div>
                </div>
            </div>




    </div>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/js/sharkcms.min.js"></script>

    <script>
        layui.use(['form', 'element', 'loading'], function() {
            var form = layui.form;
            var element = layui.element;
            var loading = layui.loading;
            
            // 请求版本信息
            sys_check()
            $("#check").click(function() {
                sys_check()
            });
            $("#update").click(function() {
                loading.block({
                    type: 1,
                    elem: '.pear-container',
                    msg: '正在更新系统'
                })
                loading.blockRemove(".pear-container", 99999);
                sys_update()
            });

            // 版本更新检查
            function sys_check() {
                $.ajax({
                    url: "https://api.sharkcms.cn/update/check.php?v=<?php echo App_V ?>&d=<?php echo sys_domain() ?>&t=<?php echo time() ?>",
                    type: "GET",
                    dataType: "jsonp",
                    jsonp: "callback",
                    success: function(data) {
                        layer.alert(data.msg)
                        // 版本号
                        document.getElementById('v').innerHTML = data.new
                        // 更新方式
                        document.getElementById('m').innerHTML = data.m
                        // 更新内容
                        document.getElementById('c').innerHTML = data.c
                        // 版本类型
                        document.getElementById('t').innerHTML = data.t
                    }
                })
            }

            // 版本更新
            function sys_update() {
                $.ajax({
                    url: "../index.php/sk-include/api?action=update",
                    type: "GET",
                    success: function(data) {
                        if (data.status == 'ok') {
                            layer.msg('更新成功');
                            loading.blockRemove(".body", 0);
                        } else {
                            layer.alert('更新失败');
                            loading.blockRemove(".body", 0);
                        }

                    }
                })
            }

        });
    </script>
</body>

</html>