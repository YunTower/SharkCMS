<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>后台 - SharkCMS内容管理系统</title>
    <link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/css/style.css" />
    <link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/css/editormd.css" />
</head>

<body class="pear-container">
    <div class="layui-row layui-col-space10">
        <!-- 基础设置 -->
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">基础设置</div>
                <div class="layui-card-body layui-row layui-col-space10">
                    <div class="layui-col-md12">
                        <div class="pear-btn-group">
                            <button plain class="pear-btn pear-btn-danger" id="edit-leave">退出编辑</button>
                            <button class="pear-btn">保存文章</button>
                            <button plain class="pear-btn pear-btn-primary">发布文章</button>
                        </div>
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" name="title" hover placeholder="文章标题" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" name="title" hover placeholder="文章简介（留空则自动截取）" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
        </div>

        <!-- 扩展设置 -->
        <div class="layui-col-md6">
            <div class="layui-card layui-form" lay-filter="component-form-element">
                <div class="layui-card-header">扩展设置（非必填）</div>
                <div class="layui-card-body layui-row layui-col-space10">

                    <div class="layui-col-md12">
                        <input type="text" name="title" hover placeholder="文章封面" autocomplete="off" class="layui-input" disabled>
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" name="title" hover placeholder="文章密码" autocomplete="off" class="layui-input" disabled>
                    </div>
                    <div class="layui-col-md12">
                        <select name="city" >
                            <option value="0">公开</option>
                            <option value="1">私密</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- 攥写文章 -->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">攥写文章</div>
                <div class="layui-card-body layui-row layui-col-space10" style="padding: 0px;">
                    <div class="layui-col-md12">
                        <!-- markdown编辑器 -->
                        <div id="layout">
                            <div id="test-editormd">
                                <textarea style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/js/jquery.min.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/js/editormd.js"></script>
    <script>
        layui.use(['form', 'element', 'code'], function() {
                    var form = layui.form;
                    var element = layui.element;
                    layui.code();

                    // 退出编辑
                    $("#edit-leave").click(function() {
                            alert('退出后不会保存已填写的内容，请谨慎退出');
                            alert('确认退出？');
                            window.location.href='/';
                        })

                    });
                var testEditor; $(function() {
                    // You can custom @link base url.
                    editormd.urls.atLinkBase = "https://github.com/";

                    testEditor = editormd("test-editormd", {
                        width: "98%",
                        toc: true,
                        //atLink    : false,    // disable @link
                        //emailLink : false,    // disable email address auto link
                        todoList: true,
                        path: '<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/lib/'
                    });
                });
    </script>
</body>

</html>