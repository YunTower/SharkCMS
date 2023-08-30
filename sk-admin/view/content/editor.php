<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>撰写文章</title>
    <link href="/sk-admin/component/pear/css/pear.css" rel="stylesheet">
    <link href="/sk-include/static/css/sharkcms.min.css" rel="stylesheet">
    <link href="/sk-include/static/css/editor.css" rel="stylesheet">

    <style>
        #editor—wrapper {
            border: 1px solid #ccc;
            z-index: 100;
            /* 按需定义 */
        }

        #editor-toolbar {
            border-bottom: 1px solid #ccc;
        }

        #editor-text-area {
            height: 400px;
        }
    </style>
</head>

<body class="pear-container">
    <form action="">
        <div class="layui-row layui-col-space10">
            <!-- 基础设置 -->
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">基础设置</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-col-md6">
                            <input type="text" name="title" placeholder="文章标题" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-col-md6">
                            <input type="text" name="slug" hover placeholder="文章摘要" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-col-md12">
                            <input type="password" id="UploadCover" hover placeholder="文章封面（点击上传，支持常见格式）" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 操作 -->
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">操作</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="pear-btn-group" style="text-align: center;">
                            <button type="button" plain class="pear-btn pear-btn-danger" style="width:30%" lay-on="leave">退出编辑</button>
                            <button plain class="pear-btn" style="width:30%">存为草稿</button>
                            <button plain class="pear-btn pear-btn-primary" style="width:30%" lay-submit lay-filter="setting" load>发布文章</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 编辑器 -->
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">编辑器（暂不支持MarkDown）</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div id="editor—wrapper">
                            <div id="editor-toolbar"><!-- 工具栏 --></div>
                            <div id="editor-text-area"><!-- 编辑器 --></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/js/editor.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        layui.use(['form', 'element', 'layer', 'util', 'upload', 'button'], function() {
            var form = layui.form,
                layer = layui.layer,
                element = layui.element,
                $ = layui.jquery,
                upload = layui.upload,
                button = layui.button,
                util = layui.util;

            const E = window.wangEditor
            const toolbarConfig = {
                excludeKeys: ['fullScreen']
            }

            // 默认内容
            window.editor = E.createEditor({
                selector: '#editor-text-area',
                config: {
                    placeholder: 'Type here...',
                    MENU_CONF: {
                        uploadImage: {
                            fieldName: 'your-fileName',
                            base64LimitSize: 10 * 1024 * 1024 // 10M 以下插入 base64
                        }
                    }
                }
            })

            window.toolbar = E.createToolbar({
                editor,
                mode: 'simple',
                selector: '#editor-toolbar',
                config: toolbarConfig
            })

            upload.render({
                elem: '#UploadCover',
                url: '/api/upload/Cover',
                accept: 'image',
                done: function(res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 1
                        });
                        var value = document.getElementById('UploadCover');
                        value.value = res.data.url;
                    } else {
                        layer.msg(res.msg, {
                            icon: 2
                        });
                    }
                }
            });

            
            util.on('lay-on', {
                // 退出编辑
                'leave': function() {
                    layer.confirm('退出后文章内容不会保存，请确认', {
                        icon: 3
                    }, function() {
                        parent.layui.admin.closeCurrentTab()
                    }, function() {
                        layer.msg('已取消', {
                            icon: 1
                        });
                    });
                    return false;
                }

            })

            // 发布文章
            form.on('submit(setting)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));
                // 按钮动画开始
                var load = button.load({
                    elem: '[load]',
                })
                // 配置axios拦截器
                axios.interceptors.request.use(config => {
                    if (config.method === 'post') {
                        config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
                    }
                    return config;
                });

                // 提交登陆
                axios.post('/api/SaveSetting', {
                        data: data
                    })
                    .then(function(response) {
                        if (response.data.code == 200) {
                            layer.msg(response.data.msg, {
                                icon: 1
                            });
                            // 按钮动画停止
                            load.stop()
                            sk.sleep(1000).then(() => {
                                parent.layui.admin.refreshThis()
                            })
                        } else {
                            layer.alert(response.data.msg, {
                                title: '保存失败',
                                icon: 2
                            })
                        }
                    })

                return false;
            });
        });
    </script>
</body>

</html>