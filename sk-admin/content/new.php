<link href="https://cdn.bootcdn.net/ajax/libs/normalize/8.0.1/normalize.min.css" rel="stylesheet">
<link href="/sk-include/static/css/editor.css" rel="stylesheet">
<form class="layui-form layui-form-pane" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <input type="text" name="title" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
        </div>
    </div>
    <!-- 编辑器 DOM -->
    <div style="border: 1px solid #ccc;">
        <div id="editor-toolbar" style="border-bottom: 1px solid #ccc;"></div>
        <div id="editor-text-area" style="height: 500px"></div>
    </div>


</form>

<script src="/sk-include/static/js/editor.js"></script>
<script>
    const E = window.wangEditor
    const toolbarConfig = {
        excludeKeys: ['fullScreen']
    }

    // 默认内容
    let html = `<p>开始创作吧</p>`
    window.editor = E.createEditor({
        selector: '#editor-text-area',
        html,
        config: {
            placeholder: 'Type here...',
            MENU_CONF: {
                uploadImage: {
                    fieldName: 'your-fileName',
                    base64LimitSize: 10 * 1024 * 1024 // 10M 以下插入 base64
                }
            },
            onChange() {
                console.log(editor.getHtml())

                // 选中文字
                const selectionText = editor.getSelectionText()
                document.getElementById('selected-length').innerHTML = selectionText.length
                // 全部文字
                // 全部文字
                const text = editor.getText().replace(/\n|\r/mg, '')
                document.getElementById('total-length').innerHTML = text.length
            }
        }
    })

    window.toolbar = E.createToolbar({
        editor,
        mode: 'simple',
        selector: '#editor-toolbar',
        config: toolbarConfig
    })
</script>