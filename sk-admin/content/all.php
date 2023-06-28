<table class="layui-hide" id="table-post-all"></table>
<script type="text/html" id="barDemo">
    <div class="layui-clear-space">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="delet">删除</a>
    </div>
</script>
<script>
    layui.use(function() {
        var table = layui.table;
        var util = layui.util;
        // 根据返回数据中某个字段来判断开启该行的编辑
        var editable = function(d) {
            return 'text'; // 这里假设以 editable 字段为判断依据
        };
        // 创建表格实例
        table.render({
            elem: '#table-post-all',
            url: '/api/get/post',
            page: true,
            //,editTrigger: 'dblclick' // 触发编辑的事件类型（默认 click ）。 v2.7.0 新增，之前版本固定为单击触发
            css: [
                // 对开启了编辑的单元格追加样式
                '.layui-table-view td[data-edit]{color: #16B777;}'
            ].join(''),
            cols: [
                [{
                        checkbox: true,
                        fixed: true
                    },
                    {
                        field: 'cid',
                        title: 'CID',
                        width: 80,
                        sort: true,
                        fixed: true
                    },
                    {
                        field: 'title',
                        title: '标题',
                        width: 200,
                        edit: editable
                    },
                    {
                        field: 'slug',
                        title: '简介',
                        width: 250
                    },
                    {
                        field: 'uid',
                        title: 'UID',
                        width: 80
                    },
                    {
                        field: 'uname',
                        title: '作者'
                    },
                    {
                        field: 'created',
                        title: '发表时间',
                        sort: true,
                        width: 200

                    },
                    {
                        fixed: 'right',
                        title: '操作',
                        width: 134,
                        minWidth: 125,
                        toolbar: '#barDemo'
                    }
                ]
            ],
            height: 500
        });
        // 单元格编辑后的事件
        table.on('edit(table-post-all)', function(obj) {
            var field = obj.field; // 得到修改的字段
            var value = obj.value // 得到修改后的值
            var oldValue = obj.oldValue // 得到修改前的值 -- v2.8.0 新增
            var data = obj.data // 得到所在行所有键值
            var col = obj.getCol(); // 得到当前列的表头配置属性 -- v2.8.0 新增

            // 值的校验
            if (value.replace(/\s/g, '') === '') {
                layer.tips('值不能为空', this, {
                    tips: 1
                });
                return obj.reedit(); // 重新编辑 -- v2.8.0 新增
            }
            // 编辑后续操作，如提交更新请求，以完成真实的数据更新
            // …

            // 显示 - 仅用于演示
            layer.msg('[ID: ' + data.id + '] ' + field + ' 字段更改值为：' + util.escape(value));
        });
    });
</script>