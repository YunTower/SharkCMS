<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>用户</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
</head>

<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <div class="layui-form-item layui-inline">
                        <label class="layui-form-label">文件名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="filename" placeholder="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-inline">
                        <button class="pear-btn pear-btn-md pear-btn-primary" lay-submit lay-filter="user-query">
                            <i class="layui-icon layui-icon-search"></i>
                            查询
                        </button>
                        <button type="reset" class="pear-btn pear-btn-md">
                            <i class="layui-icon layui-icon-refresh"></i>
                            重置
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="table" lay-filter="table"></table>
        </div>
    </div>
    <script>
        function formatTime(timestamp) {
            var time = timestamp
            var date = new Date(time * 1000);
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var second = date.getSeconds();
            return year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        }
    </script>
    <script type="text/html" id="toolbar">
        <div class="layui-btn-container">
            <form onsubmit="return false;">
                <div class="layui-input-group">
                    <input type="text" value="" placeholder="路径" id="path" class="layui-input">
                    <div class="layui-input-split layui-input-suffix" style="cursor: pointer;">
                        <i class="layui-icon layui-icon-search"></i>
                    </div>
                </div>
            </form>
        </div>
        <script>
            var path = document.getElementById('path');
            if (path.value == '') {
                path.value = './sk-content/upload/'
            }
            var default_path = path.value;
    </script>
    </script>
    <script>
        function formatTime(timestamp) {
            var time = timestamp
            var date = new Date(time * 1000);
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var second = date.getSeconds();
            return year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        }

        var types = [{
            'name': 'image',
            'list': ['.jpg', '.png', '.gif', '.jpeg', '.webp', '.ico']
        }, {
            'name': 'music',
            'list': ['.mp3', '.wav', '.ogg', '.m4a', '.flac']
        }, {
            'name': 'code',
            'list': ['.py', '.php', '.html', '.htm', '.js', '.ts', '.css', '.go', '.java', '.c']
        }, {
            'name': 'video',
            'list': ['.mp4', '.avi', '.mkv', '.flv', '.mov', '.wmv']
        }, {
            'name': 'text',
            'list': ['.txt', '.md', '.json', '.xml', '.log']
        }]

        var fileIcon = [{
                'image': '/sk-include/static/img/file/image.svg'
            },
            {
                'music': '/sk-include/static/img/file/music.svg'
            },
            {
                'code': '/sk-include/static/img/file/code.svg'
            },
            {
                'video': '/sk-include/static/img/file/video.svg'
            },
            {
                'text': '/sk-include/static/img/file/text.svg'
            },
            {
                'question': '/sk-include/static/img/file/question.svg'
            },
            {
                'folder': '/sk-include/static/img/file/folder.svg'
            }
        ]


        function getIcon(filename) {
            const regex = /\.\w+$/;
            const fileExtension = filename.match(regex)[0];
            console.log(fileExtension)
            types.forEach((item, index) => {
                if (item.list.includes(fileExtension)) {
                    return fileIcon[index][item.name]
                } else {
                    return fileIcon[5].question
                }
            });
        }
    </script>
    <script type="text/html" id="name">
        <span><img src="{{= getIcon(d.name) }}">{{= d.name }}</span>
    </script>
    <script type="text/html" id="atime">
    {{#if (d.atime != '') { }}
        <span>{{= formatTime(d.atime) }}</span>
        {{# } }}
    </script>
    <script type="text/html" id="mtime">
    {{#if (d.mtime != '') { }}
        <span>{{= formatTime(d.mtime) }}</span>
        {{# } }}
    </script>
    <script type="text/html" id="ctime">
    {{#if (d.ctime != '') { }}
        <span>{{= formatTime(d.ctime) }}</span>
        {{# } }}
    </script>
    <script type="text/html" id="bar">
        <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
        <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
    </script>

    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script>
        layui.use(['table', 'form', 'jquery', 'common', 'layer'], function() {
            let table = layui.table,
                form = layui.form,
                $ = layui.jquery,
                common = layui.common,
                layer = layui.layer;


            document.addEventListener('click', function(event) {
                if (event.srcElement.attributes[2] != null) {
                    var nodeName = event.srcElement.attributes[2].nodeName;
                    var nodeValue = event.srcElement.attributes[2].nodeValue
                    if (nodeName == 'data-url') {
                        console.log(nodeValue)
                        layer.photos({
                            photos: {
                                "title": "图片查看器",
                                "start": 0,
                                "data": [{
                                        "src": nodeValue,
                                    },

                                ]
                            }
                        });
                    }
                }
            })

            let MODULE_PATH = "/api/file";

            window.addEventListener('load', function() {
                form.on('input-affix(search)', function(data) {
                    var elem = data.elem; // 输入框
                    var value = elem.value; // 输入框的值
                    if (!value) {
                        layer.msg('请输入内容');
                        return elem.focus()
                    };
                    table.reloadData('table', {
                        url: MODULE_PATH + '/get?path=' + value
                    })
                    return false
                });
            })

            let cols = [
                [{
                        type: 'checkbox'
                    },
                    {
                        title: '文件名',
                        field: 'name',
                    },
                    {
                        title: '文件大小',
                        field: 'size',
                    },
                    {
                        title: '访问时间',
                        field: 'atime',
                        width: 150,
                        templet: '#atime'
                    },
                    {
                        title: '修改时间',
                        field: 'mtime',
                        width: 150,
                        templet: '#mtime'
                    },
                    {
                        title: '创建时间',
                        field: 'ctime',
                        width: 150,
                        templet: '#ctime'
                    },
                    {
                        title: '操作',
                        toolbar: '#bar',
                        width: 130,
                        fixed: 'right'
                    }
                ]
            ]


            table.render({
                elem: '#table',
                url: MODULE_PATH + '/get?path=' + './sk-content/upload/',
                cols: cols,
                skin: 'line',
                toolbar: '#toolbar',
                defaultToolbar: [{
                    title: '刷新',
                    layEvent: 'refresh',
                    icon: 'layui-icon-refresh',
                }]
            });

            table.on('tool(table)', function(obj) {
                if (obj.event === 'remove') {
                    window.remove(obj);
                } else if (obj.event === 'edit') {
                    window.edit(obj);
                }
            });

            table.on('toolbar(table)', function(obj) {
                if (obj.event === 'add') {
                    window.add();
                } else if (obj.event === 'refresh') {
                    window.refresh();
                } else if (obj.event === 'batchRemove') {
                    window.batchRemove(obj);
                }
            });

            form.on('submit(user-query)', function(data) {
                table.reloadData('table', {
                    where: data.field
                })
                return false;
            });

            form.on('switch(user-enable)', function(obj) {
                layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
            });

            window.add = function() {
                layer.open({
                    type: 2,
                    title: '添加',
                    shade: 0.1,
                    area: ['350px', '500px'],
                    content: '/admin/view?page=view/user/add.php',
                    end: function() {
                        table.reloadData('table');
                    }
                });
            }

            window.edit = function(obj) {
                layer.open({
                    type: 2,
                    title: '修改 - ' + obj.data.uid + ' - ' + obj.data.name,
                    shade: 0.1,
                    area: ['350px', '500px'],
                    content: '/admin/view?page=view/user/edit.php&uid=' + obj.data.uid,
                    end: function() {
                        table.reloadData('table');
                    }
                });
            }

            window.remove = function(obj) {
                layer.confirm('确定要删除该用户', {
                    icon: 3,
                    title: '提示'
                }, function(index) {
                    layer.close(index);
                    let loading = layer.load();
                    $.ajax({
                        url: MODULE_PATH + "/remove?uid=" + obj.data['uid'],
                        dataType: 'json',
                        type: 'delete',
                        success: function(result) {
                            layer.close(loading);
                            if (result.code == 200) {
                                layer.msg(result.msg, {
                                    icon: 1,
                                    time: 1000
                                }, function() {
                                    obj.del();
                                });
                            } else {
                                layer.alert(result.msg, {
                                    icon: 2,
                                });
                            }
                        }
                    })
                });
            }

            window.batchRemove = function(obj) {
                var checkIds = common.checkField(obj, 'uid');
                if (checkIds === "") {
                    layer.msg("未选中数据", {
                        icon: 3,
                        time: 1000
                    });
                    return false;
                }

                layer.confirm('确定要删除这些用户', {
                    icon: 3,
                    title: '提示'
                }, function(index) {
                    layer.close(index);
                    let loading = layer.load();
                    $.ajax({
                        url: MODULE_PATH + "/batchRemove?uid=" + checkIds,
                        dataType: 'json',
                        type: 'post',
                        success: function(result) {
                            layer.close(loading);
                            if (result.code == 200) {
                                layer.msg(result.msg, {
                                    icon: 1,
                                    time: 1000
                                }, function() {
                                    table.reload('table');
                                });
                            } else {
                                layer.alert(result.msg, {
                                    icon: 2,
                                });
                            }
                        }
                    })
                });
            }

            window.refresh = function(param) {
                table.reload('table');
            }
        })
    </script>
</body>

</html>