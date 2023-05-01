<link rel="stylesheet" href="../../sk-include/static/libs/editor.md/css/style.css" />
<link rel="stylesheet" href="../../sk-include/static/libs/editor.md/css/editormd.css" />

<div id="layout">
    <div id="test-editormd">
        <textarea style="display:none;"></textarea>
    </div>
</div>
<script src="../../sk-include/static/libs/editor.md/js/jquery.min.js"></script>
<script src="../../sk-include/static/libs/editor.md/js/editormd.js"></script>
<script type="text/javascript">
    var testEditor;

    $(function() {
        // You can custom @link base url.
        editormd.urls.atLinkBase = "https://github.com/";

        testEditor = editormd("test-editormd", {
            width: "95%",
            height: 600,
            toc: true,
            //atLink    : false,    // disable @link
            //emailLink : false,    // disable email address auto link
            todoList: true,
            path: '../../sk-include/static/libs/editor.md/lib/'
        });
    });
</script>