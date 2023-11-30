<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>数据卡片</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css"/>
</head>
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">主题名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="realName" id="realName" placeholder="" class="layui-input">
                </div>
              
                <div class="layui-inline">
                    <button type="submit" class="layui-btn layui-btn-primary" lay-submit lay-filter="data-search-btn"><i
                                class="layui-icon">&#xe615;</i>
                        搜 索
                    </button>
                    <button type="submit" class="layui-btn layui-btn-primary" lay-submit lay-filter="data-btn"><i
                                class="layui-icon">&#xe615;</i>
                        获取数据
                    </button>

                </div>
            </div>
        </form>
        <div id="currentTableId"></div>
    </div>
</div>
<script src="/sk-admin/component/layui/layui.js"></script>
<script src="/sk-admin/component/pear/pear.js"></script>
<script src="/sk-include/static/js/axios.min.js"></script>

<script>
    layui.use(['table', 'layer', 'form', 'jquery', 'card'], function () {

        let table = layui.table;
        let form = layui.form;
        let $ = layui.jquery;
        let layer = layui.layer;
        let card = layui.card;

        card.render({
            elem: '#currentTableId',
            url: '/api/getTheme', // 接口数据
            data: [], // 静态数据
            page: true, // 是否分页
            limit: 8, // 每页数量
            linenum: 4, // 每行数量
            clickItem: function (data) { // 单击事件
                axios.post('/api/theme/true', data)
            }
        })


        // 监听搜索操作
        form.on('submit(data-search-btn)', function (data) {
            queryJson = data.field;

            console.log(queryJson)
            card.reload("currentTableId", {
                where: queryJson,
            });
            return false;
        });

        // 主题卡片点击
        function cardTableCheckedCard(currentTableId) {
            console.log(card.getChecked("currentTableId"))
        }

        form.on('submit(data-btn)', function () {
            var data = card.getAllData("currentTableId");
            layer.msg(JSON.stringify(data));
            return false;
        });
    })
</script>
</body>
</html>
