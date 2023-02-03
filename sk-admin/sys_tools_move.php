<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>后台 - SharkCMS内容管理系统</title>
    <link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet">
</head>
<style>
    .alert {
        color: red
    }

    .disabled:hover {
        cursor: not-allowed;
    }
</style>

<body class="pear-container body">
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md4">
            <div class="layui-card" style="height:100%">
                <div class="layui-card-header">数据库配置（从以下数据库导出）</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <button plain class="pear-btn pear-btn-primary" id="move-sql-connect">连接测试</button>
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <input type="text" placeholder="数据库地址" value="127.0.0.1" id="sql_location" lay-verify="required" hover class="layui-input" />
                            </div>
                            <div class="layui-form-item">
                                <input type="text" placeholder="数据库名称" value="demo" id="sql_name" lay-verify="required" hover class="layui-input" />
                            </div>
                            <div class="layui-form-item">
                                <input type="text" placeholder="数据库账号" value="demo" id="sql_user" lay-verify="required" hover class="layui-input" />
                            </div>
                            <div class="layui-form-item">
                                <input type="text" placeholder="数据库密码" value="demodemo" id="sql_pwd" lay-verify="required" hover class="layui-input" />
                            </div>
                            <div class="layui-form-item">
                                <textarea style="resize: none;" disabled id="move-sql-msg" placeholder="连接信息" class="layui-textarea"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">从RapidCMS迁移</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <div class="pear-btn-group">
                            <button plain class="pear-btn pear-btn-primary" id="move_rapidcms">开始迁移</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script>
        layui.use(['form', 'element', 'loading'], function() {
            var form = layui.form;
            var element = layui.element;
            var loading = layui.loading;
            // 数据库信息
            var sql_location = $("#sql_location").val();
            var sql_name = $("#sql_name").val();
            var sql_user = $("#sql_user").val();
            var sql_pwd = $("#sql_pwd").val();
            // 数据库连接测试
            $("#move-sql-connect").click(function() {
                $.ajax({
                    url: "../../sk-include/api/tools_move_connect.php?location=" + sql_location + "&name=" + sql_name + "&user=" + sql_user + "&pwd=" + sql_pwd,
                    type: "GET",
                    success: function(data) {
                        var obj = data;
                        console.log(data);
                        $("#move-sql-msg").text(obj);
                        layer.msg(obj)
                    }
                })
            })
            // 迁移逻辑
            $("#move_rapidcms").click(function() {
                // 加载动画
                loading.block({
                    type: 1,
                    elem: '.body',
                    msg: '正在迁移文章'
                })
                loading.blockRemove(".body", 99999);
                // 获取id
                var id = ($(this).attr('id'));
                console.log('选中id：' + id);
                // 请求接口
                $.ajax({
                    url: "../../sk-include/api/tools_" + id + ".php?location=" + sql_location + "&name=" + sql_name + "&user=" + sql_user + "&pwd=" + sql_pwd,
                    type: "GET",
                    success: function(data) {
                        var obj = JSON.parse(data);
                        console.log(obj);
                        if (obj.status == 'ok') {
                            loading.blockRemove(".body", 0);
                            layer.msg(obj.msg);
                        } else {
                            loading.blockRemove(".body", 0);
                            layer.alert(obj.msg + '<br>错误代码' + obj.error);
                        }
                    }
                })
            });
        })
    </script>
</body>

</html>