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
                        <button class="pear-btn" onclick="check()">获取新版本</button>
                        <button class="pear-btn pear-btn-primary">立即更新</button>
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
                            <td>1.0.1</td>
                        </tr>
                        <tr>
                            <td>版本类型</td>
                            <td>开发版</td>
                        </tr>
                        <tr>
                            <td>更新时间</td>
                            <td>2023-8-19</td>
                        </tr>
                        <tr>
                            <td>更新类型</td>
                            <td>常规更新</td>
                        </tr>
                        <tr>
                            <td>更新内容</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!--</div>-->
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        function check() {
            update.check()
        }
    </script>
</body>

</html>