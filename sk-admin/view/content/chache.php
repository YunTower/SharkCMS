<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>文章</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
    <style>
        .layui-card {
            overflow-x: auto;
        }

        th.slug {
            overflow-y: auto;
        }

        th {

            white-space: nowrap;
            overflow-x: auto;
            max-width: 300px;
            word-break: break-all;
            word-wrap: normal;
        }
    </style>
</head>

<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <table class="layui-table lay-even">
                <colgroup>
                    <col width="80">
                    <col width="180">
                    <col width="220">
                    <col width='400'>
                    <col width="200">
                    <col width="120">

                </colgroup>
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>文章标题</th>
                        <th>文章摘要</th>
                        <th>文章内容</th>
                        <th>缓存时间</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody id="view"></tbody>
            </table>
        </div>
    </div>



    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script>
        layui.use(['table', 'common'], function() {
            let table = layui.table;
            let common = layui.common;

            const oldArticleChache = localStorage.getItem("ArticleChache");
            var view = [];
            const arr = Array.from(JSON.parse(oldArticleChache));

            // 按照时间排序
            arr.sort((a, b) => {
                const dateA = new Date(a.t);
                const dateB = new Date(b.t);
                return dateB - dateA;
            });

            // 渲染视图
            if (arr.length !== 0) {
                // 使用箭头函数遍历数组
                arr.forEach((item, index) => {
                    // 获取标题、slug和内容，如果没有，则设置为'-'
                    const itemTitle = item.title.length !== 0 ? item.title : '-';
                    const itemSlug = item.slug.length !== 0 ? item.slug : '-';
                    const itemContent = item.content.length !== 0 ? item.content : '-';

                    // 获取当前元素在数组中的索引
                    const itemId = index;

                    // 构建表格行
                    view += `<tr><th>${itemId}</th><th>${itemTitle}</th><th class="slug">${itemSlug}</th><th class="content">${itemContent}</th><th>${item.t}</th><th><button type="button" class="layui-btn layui-bg-red layui-btn-sm"  data-del="${itemId}">删除</button><button type="button" class="layui-btn layui-bg-blue layui-btn-sm" data-edit="${itemId}">编辑</button></th></tr>`;
                });
            } else {
                // 如果数组为空，则显示一条提示信息
                view = '<tr><th colspan="6" style="text-align:center">无数据</th></tr>';
            }
            document.getElementById('view').innerHTML = view;

            // 草稿操作
            document.addEventListener('click', function(event) {
                if (event.srcElement.attributes[2] != null) {

                    var nodeName = event.srcElement.attributes[2].nodeName;
                    var nodeValue = event.srcElement.attributes[2].nodeValue

                    if (nodeName == 'data-edit') {
                        parent.layui.admin.addTab(11+nodeValue, "编辑草稿-"+nodeValue, "/admin/view?page=view/content/editor.php&id=" + nodeValue)
                    } else if (nodeName == 'data-del') {
                        // 删除数组
                        arr.splice(nodeValue)
                        // 更新缓存
                        localStorage.setItem('ArticleChache', JSON.stringify(arr))
                        layer.msg('删除成功', {
                            icon: 1
                        },function(){
                            parent.layui.admin.refreshThis()
                        })
                    }
                }
            });
        })
    </script>
</body>

</html>