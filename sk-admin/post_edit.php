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
                            <button class="pear-btn" id="post-save">保存文章</button>
                            <button plain class="pear-btn pear-btn-primary" id="post-upload">发布文章</button>
                        </div>
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" id="post-title" hover placeholder="文章标题" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" id="post-introduction" hover placeholder="文章简介（留空则自动截取）" lay-verify="required" autocomplete="off" class="layui-input">
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
                        <input type="text" id="post-cover" hover placeholder="文章封面（暂不支持）" autocomplete="off" class="layui-input" disabled>
                    </div>
                    <div class="layui-col-md12">
                        <input type="text" id="post-pwd" hover placeholder="文章密码（暂不支持）" autocomplete="off" class="layui-input" disabled>
                    </div>
                    <div class="layui-col-md12">
                        <select id="post-corder">
                            <option value="0">公开（暂不支持）</option>
                            <option value="1">私密（暂不支持）</option>
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
                                <textarea id="post-edit" style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/js/editormd.js"></script>
    <script>
        layui.use(['form', 'element', 'loading'], function() {
            var form = layui.form;
            var element = layui.element;
            var loading = layui.loading;

            // MarkDown编辑器
            var testEditor;
            $(function() {
                // You can custom @link base url.
                editormd.urls.atLinkBase = "https://github.com/";
                testEditor = editormd("test-editormd", {
                    width: "98%",
                    height: "400px",
                    toc: true,
                    //atLink    : false,    // disable @link
                    //emailLink : false,    // disable email address auto link
                    todoList: true,
                    path: '<?php echo sys_domain(); ?>/sk-include/static/libs/editor.md/lib/'
                });

            });

            // 未保存提示
            window.onbeforeunload = function() {
                return '当前内容未保存';
            }
            // 文章缓存读取
            if (localStorage.getItem("sharkcms-temp-post") != null) {
                layer.open({
                    content: '发现你在 ' + localStorage.getItem("sharkcms-temp-time") + ' 保存了一篇标题为《' + localStorage.getItem("sharkcms-temp-title") + '》的文章，因未知原因未发布，是否需要恢复',
                    btn: ['恢复', '删除', '关闭'],
                    // 恢复
                    yes: function(index, layero) {

                        $("#post-title").attr('value', localStorage.getItem("sharkcms-temp-title"));
                        $.proxy(testEditor.toolbarHandlers.post, testEditor)();
                        testEditor.focus();
                        layer.close(index);
                        layer.msg('恢复成功')
                    },
                    // 删除
                    btn2: function(index, layero) {
                        //二级弹窗 删除确认
                        layer.open({
                            content: '确定删除？',
                            btn: ['确定', '关闭'],
                            yes: function(index, layero) {
                                localStorage.removeItem("sharkcms-temp-title");
                                localStorage.removeItem("sharkcms-temp-post");
                                localStorage.removeItem("sharkcms-temp-time");
                                layer.close(index);
                                layer.msg('删除成功')
                            },
                            btn2: function(index, layero) {
                                layer.close(index);
                            }
                        });
                    },
                    //关闭
                    btn3: function(index, layero) {
                        layer.close(index);
                    }
                });
            }
            // 文章保存
            function post_save() {
                var time = new Date();
                var title = $("#post-title").val();
                var content = $("#post-edit").val();
                if (title == '' || content == '') {
                    console.log('标题和内容为空，保存失败')
                } else {
                    localStorage.setItem("sharkcms-temp-title", title);
                    localStorage.setItem("sharkcms-temp-post", content);
                    localStorage.setItem("sharkcms-temp-time", time.toLocaleString());
                    console.log('文章已保存 ' + time.toLocaleString())
                }
            }
            // 点击保存
            $('#post-save').click(function() {
                post_save()
                layer.msg('文章已保存')
            })
            // 定时保存
            var save=setInterval(function temp_post() {
                post_save()
            }, 3000);
            // 文章发布
            $('#post-upload').click(function() {
                // 加载动画
                loading.block({
                    type: 1,
                    elem: '.pear-container',
                    msg: '正在发布文章'
                })
                loading.blockRemove(".pear-container", 99999);
                // 获取内容
                var post_title = $("#post-title").val();
                var post_introduction = $("#post-introduction").val();
                var post_content = $('.markdown-body').html();
                var post_cover = $("#post-cover").val();
                var post_pwd = $("#post-pwd").val();
                var post_corder = $("#post-corder").val();
                var data = ({
                    "post_title": post_title,
                    "post_introduction": post_introduction,
                    "post_content": post_content,
                    "post_cover": post_cover,
                    "post_pwd": post_pwd,
                    "post_corder": post_corder
                })

                // 请求接口
                $.ajax({
                    url: "../../index.php/sk-include/api?action=post_upload",
                    type: "POST",
                    data: data,
                    success: function(data) {
                        var obj = JSON.parse(data)
                        if (data.status == '') {
                            loading.blockRemove(".pear-container", 0);
                            layer.alert(obj.msg);
                        } else {
                            clearInterval(save);
                            loading.blockRemove(".pear-container", 0);
                            layer.msg(obj.msg);
                            // 删除文章缓存
                            localStorage.removeItem("sharkcms-temp-title");
                            localStorage.removeItem("sharkcms-temp-post");
                            localStorage.removeItem("sharkcms-temp-time");
                        }
                    }
                })
            })
            // 退出编辑
            $('#edit-leave').click(function() {
                alert('退出后不会保存已填写的内容，请谨慎退出');
                alert('确认退出？');
                parent.layui.admin.jump(22, "所有文章", "<?php echo sys_domain(); ?>/index.php/sk-admin/post_list")
            })
        });
    </script>
</body>

</html>