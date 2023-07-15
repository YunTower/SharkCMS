// wangEditor编辑器
const E = window.wangEditor;
const toolbarConfig = {
  excludeKeys: ["fullScreen", "todo"],
};
var html = "Hello World ! 你好世界 !";

window.editor = E.createEditor({
  selector: "#editor-text-area",
  html,
  config: {
    placeholder: "请开始创作...（提示：编辑器不支持MarkDown语法！）",
    MENU_CONF: {
      uploadImage: {
        fieldName: "your-fileName",
        base64LimitSize: 10 * 1024 * 1024, // 10M 以下插入 base64
      },
    },
  },
});

window.toolbar = E.createToolbar({
  editor,
  mode: "simple",
  selector: "#editor-toolbar",
  config: toolbarConfig,
});

// layui
layui.use(function () {
  var form = layui.form;
  var layer = layui.layer;
  var upload = layui.upload;

  // 封面文件上传
  upload.render({
    elem: "#cover-upload",
    url: "/api/upload/cover",
    filed:'file',
    accept: "images",
    acceptMime: "image/png,image/jpg,image/jpeg,image/webp",
    done: function (res) {
      if (res.code == 200) {
        layer.msg(res.msg);
        $("#cover-upload").val(res.data);
      } else {
        layer.msg(res.error, {
          icon: 2,
        });
      }
    },
  });

  // 文章发表
  form.on("submit(save)", function () {
    var dataTitle = $("input[name=title]").val();
    var dataSlug = $("input[name=slug]").val();
    var dataPost = editor.getHtml();
    var dataCover=$("input[name=cover]").val();
    var dataPwd=$("input[name=pwd]").val();

    if (dataTitle.length > 60 || dataSlug > 60) {
      layer.msg("【标题】或【简介】不能大于60个字符", { icon: 2 });
    } else {
      var data = JSON.parse(
        JSON.stringify({
          title: dataTitle,
          slug: dataSlug,
          post: dataPost,
          cover: dataCover,
          pwd: dataPwd,
        })
      );

      if (!data.title || !data.slug || !data.post) {
        layer.msg("【标题】【简介】或【内容】不得为空!", { icon: 2 });
      } else {
        $.ajax({
          type: "POST",
          url: "/api/post/save",
          dataType: "json",
          data: Base64.encode(JSON.stringify(data)),
          contentType: "application/jsoan",
          success: function (data) {
            // 加载动画
            var loadIndex = layer.msg("保存中", {
              icon: 16,
              shade: 0.01,
            });

            // 连接状态
            if (data.code == 200) {
              // if 200 ==> 弹出层 && 跳转 /admin/index
              layer.close(loadIndex);
              layer.msg("文章保存成功", {
                time: 5 * 1000,
                icon: 1,
              });
              window.location.href = "/admin/content/all";
            } else {
              // 弹出层
              layer.close(loadIndex);
              layer.alert(data.error, {
                title: "文章保存失败",
                icon: "2",
              });
            }
          },
        });
      }
    }
    return false;
  });
});
