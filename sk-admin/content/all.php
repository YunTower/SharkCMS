<div class="sk-table">
    <table class="layui-hide" id="table-news"></table>
</div>
<script type="text/html" id="status">
  <!-- 这里的 checked 的状态值判断仅作为演示 -->
  <input type="checkbox" name="status" value="{{= d.id }}" title="私密|公开" lay-skin="switch" lay-filter="demo-templet-status" {{= d.id == 10001 ? "checked" : "" }}>
</script>
<script type="text/html" id="ID-table-demo-templet-other">
  <span class="layui-badge-rim" style="margin-right: 10px;">{{= d.score }}</span>

</script>
<script>
    layui.use('table', function() {
        var table = layui.table;

        // 创建渲染实例
        table.render({
            elem: '#table-news',
            url: '/api/post/list', // 此处为静态模拟数据，实际使用时需换成真实接口
            cols: [
                [{
                        field: 'cid',
                        width: 50,
                        title: 'ID',
                        sort: true
                    },
                    {
                        field: 'title',
                        width: 200,
                        title: '标题'
                    },
                    {
                        field: 'category',
                        width: 150,
                        title: '分类'
                    },
                    {
                        field: 'tag',
                        width: 150,
                        title: '标签'
                    },
                    {
                        field: 'status',
                        width: 100,
                        title: '状态',
                        templet:'#status'
                    },
                    {
                        field: 'uname',
                        width: 100,
                        title: '作者'
                    },
                    {
                        field: 'allowComment',
                        width: 100,
                        title: '评论',
                        templet:'#'
                    },
                    {
                        field: 'created',
                        width: 180,
                        title: '时间',
                        sort: true
                    },
                    {
                        width:150,
                        title:'操作',
                        templet:'#'
                    }
                    
                ]
            ]
        });

    });
</script>