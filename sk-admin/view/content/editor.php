<?php

use FrameWork\FrameWork;
use FrameWork\View\View;
use FrameWork\Hook\Hook;

function data()
{
    if (isset($_GET['action'], $_GET['cid']) && $_GET['action'] == 'edit') {
        $cid = htmlentities($_GET['cid']);
        return View::find('article', ['cid', $cid]);
    }
}
function _edit()
{
    if (isset($_GET['action'], $_GET['cid']) && $_GET['action'] == 'edit') {
        if (empty(data())) {
            FrameWork::WARNING(0, ['系统错误', '文章不存在']);
            exit;
        }
        return data()[0];
    }
}

?>
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

        .right {
            padding: 10px 0
        }

        .right input {}

        .right #upload {
            border-radius: 4px;
            border-radius: 0 4px 4px 0;

        }

        .right .layui-colla-content {
            padding: 10px 5px;
        }

        .layui-colla-content .layui-form-checkbox {
            margin-bottom: 5px;
        }
    </style>
</head>

<body class="pear-container">
    <form action="" class="layui-form" onsubmit="return false;">
        <div class="layui-col-space10">
            <!-- 基础设置 -->
            <div class="layui-col-md9">
                <div class="layui-card">
                    <div class="layui-card-header">基础设置</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-col-md12">
                            <input type="text" name="title" placeholder="文章标题" value="<?php if (_edit()) echo _edit()['title'] ?>" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-col-md12">
                            <textarea name="slug" placeholder="文章摘要" autocomplete="off" class="layui-textarea"><?php if (_edit()) echo _edit()['slug'] ?></textarea>
                        </div>
                    </div>
                </div>
                <!-- 编辑器 -->
                <div class="layui-card">
                    <div class="layui-card-header">编辑器</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div id="editor" style="z-index: 9999;">
                            <textarea name="content" id="content"><?php if (_edit()) echo _edit()['content'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 操作 -->
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">操作</div>
                    <div class="layui-card-body layui-row layui-col-space10">
                        <button plain class="pear-btn pear-btn-primary" lay-submit lay-filter="setting" load>发布文章</button>
                        <button plain class="pear-btn" lay-submit lay-filter="ArticleChache">存为草稿</button>
                        <!-- <button type="button" plain class="pear-btn pear-btn-danger" style="width:30%" lay-on="leave">退出编辑</button> -->

                        <!--右侧功能栏-->
                        <div class="right">
                            <div class="layui-collapse">
                                <div class="layui-colla-item">
                                    <div class="layui-colla-title">封面</div>
                                    <div class="layui-colla-content layui-show">
                                        <div class="layui-form-item">
                                            <div class="layui-input-group">
                                                <div class="layui-input-split layui-input-prefix layui-input-split-left">
                                                    封面
                                                </div>
                                                <input type="text" name="cover" placeholder="" value="<?php if (_edit()) echo _edit()['cover'] ?>" class="layui-input" id="upload-value">
                                                <div class="layui-input-suffix">
                                                    <button class="layui-btn layui-btn-primary" id="upload">上传</button>
                                                </div>
                                                <div class="layui-upload-list" id="upload-demo-preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-colla-item">
                                    <div class="layui-colla-title">分类</div>
                                    <div class="layui-colla-content layui-show">
                                        <?php
                                        foreach (View::getCategories() as $category) {
                                            if (_edit() && _edit()['category'] == $category['name']) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }
                                            echo '<input type="checkbox"lay-filter="category"  name="category[' . $category['name'] . ']" title="' . $category['name'] . '" lay-skin="tag" ' . $checked . '>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="layui-colla-item">
                                    <div class="layui-colla-title">标签</div>
                                    <div class="layui-colla-content">
                                        <input type="text" name="tag" placeholder="请输入标签（以英文逗号分割）" value="<?php if (_edit()) {
                                                                                                                foreach (json_decode(_edit()['tag']) as $data) {
                                                                                                                    $index = array_search($data, json_decode(_edit()['tag']));
                                                                                                                    $count = count(json_decode(_edit()['tag']));
                                                                                                                    if ($index === $count - 1) {
                                                                                                                        echo $data;
                                                                                                                    } else {
                                                                                                                        echo $data . ',';
                                                                                                                    }
                                                                                                                }
                                                                                                            } ?>" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-colla-item">
                                    <div class="layui-colla-title">权限</div>
                                    <div class="layui-colla-content">
                                        <input type="checkbox" name="top" title="置顶文章" <?php if (_edit() && _edit()['top'] == 1) echo 'checked' ?>>
                                        <input type="checkbox" name="allowComment" title="允许评论" <?php if (_edit() && _edit()['allowComment'] == 1) echo 'checked' ?>>
                                        <input type="checkbox" name="private" title="不公开" <?php if (_edit() && _edit()['status'] == 1) echo 'checked' ?>>
                                    </div>
                                </div>
                                <?= Hook::add('admin-article-edit-right', ''); ?>

                            </div>

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
        layui.use(['form', 'element', 'layer', 'util', 'upload', 'button', 'encrypt'], function() {
            var form = layui.form,
                layer = layui.layer,
                element = layui.element,
                upload = layui.upload,
                button = layui.button,
                util = layui.util,
                encrypt = layui.encrypt;
            const oldArticleChache = localStorage.getItem("ArticleChache");
            var categoryItem = [];
            var request_url = '/api/article/add';
            if (sk.getData()['action'] == 'edit') {
                var request_url = '/api/article/edit';
            }


            $(function() {
                // 初始化编辑器
                var editor = editormd("editor", {
                    width: "98%",
                    height: "100vh",
                    path: "/sk-include/static/lib/editor/lib/"
                });
            });

            form.on('checkbox(category)', function(data) {
                // 如果 checkbox 元素被选中
                if (data.elem.checked) {
                    // 如果已经选择了两个分类，提示最多只能选择两个分类，并取消选中该分类
                    if (categoryItem.length >= 1) {
                        layer.msg('最多只能选择1个分类', {
                            icon: 2
                        });

                        data.elem.checked = false;
                        data.othis[0].classList.remove('layui-form-checked')
                        return false
                    } else {
                        // 获取当前分类名称
                        var categoryName = data.elem.name;
                        // 如果该分类名称不存在于 categoryItem 数组中，则将其添加到数组中
                        if (categoryItem.indexOf(categoryName) === -1) {
                            categoryItem.push(categoryName);
                        }
                    }
                } else {
                    // 如果 checkbox 元素未被选中，则从 categoryItem 数组中移除该分类名称
                    var categoryName = data.elem.name;
                    if (categoryItem.indexOf(categoryName) !== -1) {
                        categoryItem.splice(categoryItem.indexOf(categoryName), 1);
                    }
                }
            });



            // 封面上传
            upload.render({
                elem: '#upload',
                url: '/api/upload?type=cover',
                accept: 'image',
                done: function(res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 1
                        });
                        var value = document.getElementById('upload-value');
                        value.value = res.data.url;
                    } else {
                        layer.msg(res.msg, {
                            icon: 2
                        });
                    }
                    return false
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

            // 文章缓存
            form.on('submit(ArticleChache)', function(data) {
                const dataStr = JSON.stringify(data.field);
                const dataObj = JSON.parse(dataStr);
                const t = new Date().toLocaleString();
                const article = dataObj.content;
                const title = dataObj.title;
                const slug = dataObj.slug;
                const chacheData = {
                    t: t,
                    title: title,
                    slug: slug,
                    content: article
                };

                // 如果本地存储中有旧数据，则将其转换为数组
                let oldData;
                if (oldArticleChache) {
                    oldData = Array.from(JSON.parse(oldArticleChache));
                }

                // 将新数据添加到旧数据中，然后将新数组转换为字符串并存储到本地存储中
                const newItem = oldData ? [...oldData, chacheData] : [chacheData];
                localStorage.setItem("ArticleChache", JSON.stringify(newItem));

                // 显示成功消息
                layer.msg('保存成功', {
                    icon: 1
                });

                // 返回 false 以阻止表单的默认提交行为
                return false;
            });

            // 发布文章
            form.on('submit(setting)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));
                if (data.title == '' || data.slug == '' || data.content == '') {
                    layer.msg('请填写【标题、摘要、文章内容】', {
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
                axios.post(request_url + "?cid=" + sk.getData()['cid'], data)
                    .then(function(response) {
                        if (response.data.code == 200) {
                            layer.msg(response.data.msg, {
                                icon: 1
                            });
                            // 按钮动画停止
                            load.stop()
                            sk.sleep(1000).then(() => {
                                parent.layui.admin.jump(201, "文章", "/admin/view?page=view/content/article.php")
                            })
                        } else {
                            layer.alert(response.data.msg, {
                                title: '保存失败',
                                icon: 2
                            })
                        }
                    })
                load.stop()


                return false;
            });
        });
    </script>
</body>

</html>