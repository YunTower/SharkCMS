<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>设置</title>
    <link href="/sk-admin/component/pear/css/pear.css" rel="stylesheet">
</head>
<body class="pear-container">
<div class="layui-row layui-col-space10">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                    <ul class="layui-tab-title">
                        <li class="layui-this">网站设置</li>
                        <li>文章设置</li>
                        <li>用户设置</li>
                        <li>评论设置</li>
                        <li>系统设置</li>
                        <li>SEO设置</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <form method="POST">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">站点标题:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <input type="text" name="site-title" placeholder="" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">站点副标题:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <input type="text" name="site-" placeholder="" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">站点图标:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <input type="text" name="title" placeholder="点击上传" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">自定义页头:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <textarea name="" placeholder="将应用于所有页面" class="layui-textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">自定义页脚:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <textarea name="" placeholder="将应用于所有页面" class="layui-textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="layui-tab-item">
                            <form>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">单页数量:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <input type="number" name="title" placeholder="单页面显示的文章数量，将应用于全局" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">允许评论:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <div class="layui-form" lay-filter="component-form-element">
                                            <input type="checkbox" name="yyy" lay-skin="switch" lay-text="开启|关闭" checked>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="layui-tab-item">
                            <div class="layui-form-item">
                                <label class="layui-form-label">允许注册:</label>
                                <div class="layui-input-block">
                                    <div class="layui-col-md3">
                                        <div class="layui-form" lay-filter="component-form-element">
                                            <input type="checkbox" name="yyy" lay-skin="switch" lay-text="开启|关闭" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-tab-item">
                            <form>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">允许评论:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <div class="layui-form" lay-filter="component-form-element">
                                                <input type="checkbox" name="yyy" lay-skin="switch" lay-text="开启|关闭" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">评论审核:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <div class="layui-form" lay-filter="component-form-element">
                                                <input type="checkbox" name="yyy" lay-skin="switch" lay-text="开启|关闭" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">登陆后评论:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <div class="layui-form" lay-filter="component-form-element">
                                                <input type="checkbox" name="yyy" lay-skin="switch" lay-text="开启|关闭" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">单页数量:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md3">
                                            <input type="number" name="title" placeholder="单页面显示的评论数量，将应用于全局" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="layui-tab-item">
                            <p>暂无功能可设置</p>
                        </div>
                        <div class="layui-tab-item">
                            <form>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">站点关键词:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <input type="text" name="title" placeholder="" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">站点描述:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-col-md6">
                                            <input type="text" name="title" placeholder="" autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/sk-admin/component/layui/layui.js"></script>
<script src="/sk-admin/component/pear/pear.js"></script>
<script>
    layui.use(['form', 'element', 'code'], function () {
        var form = layui.form;
        var element = layui.element;

        layui.code();

    });
</script>
</body>
</html>