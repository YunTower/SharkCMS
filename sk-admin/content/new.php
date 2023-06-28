<link href="https://cdn.bootcdn.net/ajax/libs/normalize/8.0.1/normalize.min.css" rel="stylesheet">
<link href="/sk-include/static/css/editor.css" rel="stylesheet">

<form class="layui-form layui-form-pane" action="">
    <!-- 基础功能 -->
    <div class="sk-admin-editor-top">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" value="Hello World" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">简介</label>
            <div class="layui-input-block">
                <input type="text" name="slug" value="Hello World" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
            </div>
        </div>
        <div style="border: 1px solid #ccc;">
            <div id="editor-toolbar" style="border-bottom: 1px solid #ccc;"></div>
            <div id="editor-text-area" style="height: 500px"></div>
        </div>
    </div>

    <!-- 扩展设置 -->
    <div class="sk-admin-editor-bottom">
        <div class="layui-collapse lay-accordion">
            <div class="layui-colla-item">
                <div class="layui-colla-title">扩展设置</div>
                <div class="layui-colla-content layui-show">
                    <!-- --- -->
                    <div class="layui-form-item">
                        <label class="layui-form-label">文章封面</label>
                        <div class="layui-input-block">
                            <input type="text" name="cover" id="cover-upload" readonly="readonly" autocomplete="off" placeholder="点击上传" lay-verify="required" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">文章密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="pwd" autocomplete="off" placeholder="点击填写" lay-verify="required" class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="/sk-include/static/js/editor.js"></script>
<script src="/sk-include/static/js/sharkcms.newpost.js"></script>
<script>
    $('#sk-toolbar-top').show();
    $('#sk-toolbar-bottom').show();
</script>