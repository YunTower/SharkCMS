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
                <div class="layui-card-header">更新详情</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <p id="update-info"></p>
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
                var form = layui.form,
                    element = layui.element,
                    loading = layui.loading,
                    key = '<?php get_key() ?>';


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
                        url: "https://api.sharkcms.cn/update/<?php echo App_T ?>/check.php?v=<?php echo App_V ?>&d=<?php echo sys_domain() ?>&t=<?php echo time() ?>",
                        type: "GET",
                        dataType: "jsonp",
                        jsonp: "callback",
                        success: function(data) {
                            if (data.install == 'no') {
                                layer.msg(data.msg);
                                document.getElementById('update-info').innerHTML = '当前已是最新版本';
                            } else {
                                layer.alert(data.msg)
                                document.getElementById('update-info').innerHTML = "<p>版本号：<a id='v'></a></p><p>更新方式：<a id='m'></a></p><p>版本类型：<a id='t'></a></p><p>更新方式：<a id='c'></a></p>"
                                // 版本号
                                document.getElementById('v').innerHTML = data.new
                                // 更新方式
                                document.getElementById('m').innerHTML = data.m
                                // 更新内容
                                document.getElementById('c').innerHTML = data.c
                                // 版本类型
                                document.getElementById('t').innerHTML = data.t
                            }

                        }
                    })
                }

                // 版本更新
                function sys_update() {
                    $.ajax({
                        url: "../index.php/sk-include/api?action=update",
                        type: "GET",
                        headers: {
                            'Content-Type': 'application/json;charset=utf8',
                            'key': key
                        },
                        success: function(data) {
                            var obj = JSON.parse(data)
                            console.log(obj)
                            layer.msg(obj.msg);
                            loading.blockRemove(".pear-container", 0);
                        }
                    })
                }

            });
        </script>
</body>

</html>