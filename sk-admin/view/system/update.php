<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>控制后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
    <link rel="stylesheet" href="/sk-admin/admin/css/other/console1.css" />
    <link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />

</head>

<body class="pear-container">

    <div class="layui-row layui-col-space10">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    检查更新
                </div>
                <div class="layui-card-body">
                    <div class="pear-btn-group">
                        <button class="pear-btn" check>获取新版本</button>
                        <button class="pear-btn pear-btn-primary" updateDo>立即更新</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">
                    版本信息
                </div>
                <div class="layui-card-body">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                        </colgroup>
                        <tr>
                            <td>版本号</td>
                            <td id="version"></td>
                        </tr>
                        <tr>
                            <td>版本类型</td>
                            <td id="type"></td>
                        </tr>
                        <tr>
                            <td>更新时间</td>
                            <td id="time"></td>
                        </tr>
                        <tr>
                            <td>更新类型</td>
                            <td id="tag"></td>
                        </tr>
                        <tr>
                            <td>文件大小</td>
                            <td id="size"></td>
                        </tr>
                        <tr>
                            <td>更新内容</td>
                            <td id="info"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!--</div>-->
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        layui.use(['element', 'layer', 'jquery', "button", 'loading'], function() {
            var element = layui.element,
                $ = layui.jquery,
                button = layui.button,
                layer = layui.layer,
                loading = layui.loading;


            var check;

            $("[check]").click(function() {
                check = button.load({
                    elem: '[check]'
                })

                update.check(function(res) {
                    if (res == null) {
                        layer.msg('云端错误：' + res, {
                            icon: 2,
                            time: 2000
                        });

                    } else {
                        if (res.code == 200) {
                            var a = res.data.info;
                            layer.msg('发现新版本')
                            var version = document.getElementById("version");
                            var type = document.getElementById("type");
                            var time = document.getElementById("time");
                            var tag = document.getElementById("tag");
                            var size =document.getElementById("size");
                            var info = document.getElementById("info");

                            version.innerHTML = a.version;
                            type.innerHTML = a.type;
                            time.innerHTML = a.created;
                            tag.innerHTML = a.tag;
                            size.innerHTML = a.size;
                            info.innerHTML = a.info;

                        } else {
                            layer.msg('云端错误：' + res.msg, {
                                icon: 2,
                                time: 2000
                            });
                        }
                    }
                    check.stop()
                })
            })

            var updateDo;
            $("[updateDo]").click(function() {
                updateDo = button.load({
                    elem: '[updateDo]'
                })

                update.do(function(res) {
                    console.log(res)
                    if (res == null) {
                        layer.msg('云端错误：' + res, {
                            icon: 2,
                            time: 2000
                        });
                    } else {
                        loading.Load(3, '正在更新');
                        if (res.code == 200) {
                            layer.msg('更新成功', {
                                icon: 1,
                                time: 2000
                            });
                            loading.loadRemove(0);
                        } else {
                            layer.alert(res.msg, {
                                title: '更新失败',
                                icon: 2
                            })
                            loading.loadRemove(0);

                        }
                    }
                    updateDo.stop()
                })
            })
        })
    </script>
</body>

</html>