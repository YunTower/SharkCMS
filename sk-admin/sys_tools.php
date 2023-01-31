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
</style>

<body class="pear-container body">
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">数据迁移</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <div class="pear-btn-group">
                            <p class="alert">此功能目前仅支持迁移文章</p>
                            <button class="pear-btn" id="move">迁移选项</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">缓存清理</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <p class="alert">删除系统缓存，减少占用</p>
                        <button class="pear-btn" id="check">立即清理</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">一键跑路（不保留任何数据）</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <p class="alert">此功能会删除系统根目录和数据库，谨慎使用</p>
                        <button plain class="pear-btn pear-btn-danger" id="test">立即跑路</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">一键重置（不保留任何数据）</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <p class="alert">此功能会重置系统配置文件和数据库，谨慎使用</p>
                        <button plain class="pear-btn pear-btn-danger" id="check">立即重置</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>

    <script>
        layui.use(['form', 'element', 'loading'], function() {
            var form = layui.form;
            var element = layui.element;
            var loading = layui.loading;
            $("#move").click(function() {
                layer.open({
                    type: 2,
                    title: '数据迁移',
                    String: 1,
                    area: ['100%', '100%'],
                    btn: ['关闭'],
                    btnAlign: 'c',
                    yes: function(index, layero) {
                        layer.close(index);
                    },
                    content: '<?php echo sys_domain(); ?>/index.php/sk-admin/sys_tools_move'
                });
            });
            $("#test").click(function() {
                loading.block({
                    type: 1,
                    elem: '.body',
                    msg: '正在迁移文章'
                })
                loading.blockRemove(".body", 1999);

            });
        })
    </script>
</body>

</html>