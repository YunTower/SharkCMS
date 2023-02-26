<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" style="border-bottom: none;">
                    <ul class="layui-tab-title" style="border-bottom: none;">
                        <li class="layui-this" style="border-bottom: none;">基础设置</li>
                        <li>菜单设置</li>
                        <li>页面设置</li>
                        <li>文章设置</li>
                        <li>评论设置</li>
                        <li>自定义</li>
                    </ul>
                    <div class="layui-tab-content">
                        <!-- 基础设置 -->
                        <div class="layui-tab-item layui-show">
                            <div class="layui-card">
                                <div class="layui-card-header">基础设置</div>
                                <div class="layui-card-body layui-row layui-col-space10">
                                    <form class="layui-form layui-form-pane" action="">
                                        <div class="layui-form-item" pane>
                                            <label class="layui-form-label">网站主标题</label>
                                            <div class="layui-input-block">
                                                <input type="text" id="post-cover" hover placeholder="网站主标题" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" pane>
                                            <label class="layui-form-label">网站次标题</label>
                                            <div class="layui-input-block">
                                                <input type="text" id="post-cover" hover placeholder="网站次标题" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item" pane>
                                            <label class="layui-form-label">网站LOGO</label>
                                            <div class="layui-input-block">
                                                <input type="text" id="post-cover" hover placeholder="网站LOGO" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 菜单设置 -->
                    <div class="layui-tab-item">内容2</div>
                </div>
            </div>
        </div>
    </div>


    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script>
        layui.use(['form', 'element', 'loading'], function() {
            var form = layui.form,
                element = layui.element,
                loading = layui.loading,
                key = '<?php get_key() ?>';

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
                    headers: {
                        'Content-Type': 'application/json;charset=utf8',
                        'key': key
                    },
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
                    headers: {
                        'Content-Type': 'application/json;charset=utf8',
                        'key': key
                    },
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