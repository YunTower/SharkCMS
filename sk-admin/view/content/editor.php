<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>撰写文章</title>
    <link href="/sk-admin/component/pear/css/pear.css" rel="stylesheet">
    <link href="/sk-include/static/css/sharkcms.min.css" rel="stylesheet">
    <link href="/sk-include/static/css/editor.css" rel="stylesheet">
    <link rel="stylesheet" href="/sk-include/static/lib/editor/css/editormd.css" />

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
    <form action="" class="layui-form">
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
                            <div class="layui-form-item">
                                <div class="layui-input-group">
                                    <div class="layui-input-split layui-input-prefix layui-input-split-left">
                                        封面
                                    </div>
                                    <input type="text" id="UploadCover" hover placeholder="文章封面（点击上传，支持常见格式）" autocomplete="off" class="layui-input">
                                    <div class="layui-input-split layui-input-suffix layui-input-split-right" style="color: #2d8cf0;" id="Preview" lay-on="preview">
                                        预览
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- 操作 -->
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">操作</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div style="text-align: center;">
                            <button type="button" plain class="pear-btn pear-btn-danger" style="width:30%" lay-on="leave">退出编辑</button>
                            <button plain class="pear-btn" style="width:30%" lay-submit lay-filter="ArticleChache">存为草稿</button>
                            <button type="button" plain class="pear-btn" style="width:30%" lay-on="ViewChache">我的草稿</button>

                            <button plain class="pear-btn pear-btn-primary" style="width:30%" lay-submit lay-filter="setting" load>发布文章</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 编辑器 -->
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">编辑器</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div id="editor">
                            <textarea name="content" id="content">### 关于 Editor.md
**Editor.md** 是一款开源的、可嵌入的 Markdown 在线编辑器（组件），基于 CodeMirror、jQuery 和 Marked 构建。</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/lib/jquery.min.js"></script>
    <script src="/sk-include/static/lib/editor/editormd.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        layui.use(['form', 'element', 'layer', 'util', 'upload', 'button'], function() {
            var form = layui.form,
                layer = layui.layer,
                element = layui.element,
                upload = layui.upload,
                button = layui.button,
                util = layui.util;
            const oldArticleChache = localStorage.getItem("ArticleChache");

            // 生成草稿视图
            function getChacheView() {
                var view = [];
                const oldArticleChache = localStorage.getItem("ArticleChache");
                const arr = Array.from(JSON.parse(oldArticleChache));
                arr.forEach(function(item) {
                    var itemTitle = item['title'].length != 0 ? item.title : '无';
                    var itemSlug = item['slug'].length != 0 ? item.slug : '无';
                    var itemContent = item['content'].length != 0 ? item.content : '无';

                    view = view + '<br>标题：' + itemTitle + '<br>简介：' + itemSlug + '<br>内容：' + itemContent

                });
                return view
            }


            // 初始化编辑器
            $(function() {
                var editor = editormd("editor", {
                    width: "100%",
                    height: "100vh",
                    path: "/sk-include/static/lib/editor/lib/"
                });
            });

            // 封面上传
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
                },
                // 开始草稿窗口
                'ViewChache': function() {
                    if (oldArticleChache != null) {
                        layer.open({
                            type: 1,
                            title: '文章草稿',
                            shade: 0.1,
                            area: ['auto', '400px'],
                            content: getChacheView(),

                        });
                    }
                    return false
                }


            })

            // 文章缓存
            form.on('submit(ArticleChache)', function(data) {
                const dataStr = JSON.stringify(data.field);
                const dataObj = JSON.parse(dataStr);
                const t = new Date().toLocaleString();
                const article = dataObj.content;
                const title = dataObj.title;
                const slug = dataObj.slug;
                var chacheData = {
                    t: t,
                    title: title,
                    slug: slug,
                    content: article
                };

                if (oldArticleChache) {
                    let oldData = Array.from(JSON.parse(oldArticleChache));
                    let newItem = [...oldData, chacheData];
                    var chacheData = newItem;
                }

                localStorage.setItem("ArticleChache", JSON.stringify(chacheData));
                layer.msg('保存成功', {
                    icon: 1
                });
                return false;
            });

            // 发布文章
            form.on('submit(setting)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));
                if (data.title == '' || data.slug == '' || data.content == '') {
                    layer.msg('请填写【标题】或【摘要】或【文章内容】', {
                        icon: 2
                    })
                    return false;
                }

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