<table class="layui-hide" id="ID-table-demo-page"></table>
<script type="text/html" id="barDemo">
    <div class="layui-clear-space">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs" lay-event="more">
            更多
            <i class="layui-icon layui-icon-down"></i>
        </a>
    </div>
</script>
<script>
    layui.use('table', function() {
        var table = layui.table;

        // 创建渲染实例
        table.render({
            elem: '#ID-table-demo-page',
            url: '/api/file/list', // 此处为静态模拟数据，实际使用时需换成真实接口
            page: { // 支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
                //curr: 5, //设定初始在第 5 页
                groups: 1, //只显示 1 个连续页码
                first: false, //不显示首页
                last: false //不显示尾页
            },
            // toolbar:'#barDemo',
            cols: [
                [{
                        field: 'data.name',
                        width: 300,
                        title: '文件名称'
                    },
                    {
                        field: 'data.size',
                        width: 150,
                        title: '文件大小'
                    },
                    {
                        field: 'data.type',
                        width: 150,
                        title: '文件类型'
                    },
                    {
                        field: 'data.time',
                        width: 150,
                        title: '修改时间'
                    },
                    {
                        fixed: 'right',
                        title: '操作',
                        width: 134,
                        minWidth: 125,
                        toolbar: '#barDemo'
                    }
                ]
            ]
        });
        // 底部分页栏事件
        table.on('pagebar(ID-table-demo-page)', function(obj) {
            var eventValue = obj.event; // 获得按钮 lay-event 值
            layer.msg(eventValue);
        });
    });
</script>