<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>用户</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
    <style>
        .icon {
            height: 26px;
            width: 26px;
            padding: 5px;
        }

        .folder a:hover {
            color: #2D8CF0;
            text-decoration: underline;
        }
    </style>
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
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix layui-input-split" lay-on="back">
                        <i class="layui-icon layui-icon-left"></i>
                    </div>
                    <input type="text" id="path" value="" placeholder="路径" id="path" lay-affix="search" lay-filter="search" class="layui-input">
                </div>
            </form>
        </div>
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

            // 循环读取变量types，验证fileExtension是否包含于types的list中
            for (let i = 0; i < types.length; i++) {
                if (types[i].list.includes(fileExtension)) {
                    return fileIcon[i][types[i].name];
                }
            }
            return fileIcon[fileIcon.length - 1]['folder']; // 如果没有匹配的类型，则返回文件夹图标
        }

        function getFileType(filename) {
            const regex = /\.\w+$/;
            const fileExtension = filename.match(regex)[0];
            // 循环读取变量types，验证fileExtension是否包含于types的list中,若包含则输出name
            for (let i = 0; i < types.length; i++) {
                if (types[i].list.includes(fileExtension)) {
                    return types[i].name;
                }
            }
            return 'folder'; // 如果没有匹配的类型，则返回文件夹
        }
    </script>
    <script type="text/html" id="name">
    {{#if (d.type == 0) { }}
        <span class="folder" title="单击打开此文件夹（{{= d.path }}）">
            <img class="icon" src="{{= fileIcon[6].folder }}"><a data-type="folder" data-name="{{= d.name }}" data-path="{{= d.path }}">{{= d.name }}</a>
        </span>
        {{# }else { }}
            <span class="file" title="单击打开此文件（{{= d.path }}）">
                <img class="icon" src="{{= getIcon(d.name) }}"><a data-type="file" data-name="{{= d.name }}" data-path="{{= d.path }}" data-filetype="{{= getFileType(d.name) }}">{{= d.name }}</a>
            </span>
            {{# } }}
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
        <div class="layui-clear-space">
            <a class="layui-btn layui-bg-blue layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-bg-red layui-btn-xs" lay-event="remove">删除</a>
        </div>
    </script>

    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script>
        layui.use(['table', 'form', 'jquery', 'common', 'layer', 'util'], function() {
            let table = layui.table,
                form = layui.form,
                $ = layui.jquery,
                common = layui.common,
                layer = layui.layer,
                util = layui.util;

            // 获取数据
            document.addEventListener('click', function(event) {
                if (event.srcElement.attributes[0] != null && event.srcElement.attributes[1] != null && event.srcElement.attributes[2] != null) {
                    var type = event.srcElement.attributes[0].nodeValue;
                    var name = event.srcElement.attributes[1].nodeValue;
                    var path = event.srcElement.attributes[2].nodeValue;
                    if (type == 'file' && event.srcElement.attributes[3].nodeValue != null) {
                        var filetype = event.srcElement.attributes[3].nodeValue;
                    }
                    var inputPath = document.getElementById('path');
                    if (type == 'folder') {
                        inputPath.value = path;
                        table.reloadData('table', {
                            url: MODULE_PATH + '/get?path=' + path
                        })
                    } else if (filetype != null && filetype == 'image') {
                        console.log('打开图片')
                        layer.photos({
                            photos: {
                                "title": "图片查看",
                                "start": 0,
                                "data": [{
                                    'src': path.slice(path.indexOf('.') + 1)
                                }]
                            }
                        });
                    }
                }
            })

            let MODULE_PATH = "/api/file";

            // 监听搜索按钮
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
                return false;
            });






            let cols = [
                [{
                        type: 'checkbox'
                    },
                    {
                        title: '文件名',
                        field: 'name',
                        templet: '#name'
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
                }],
                done: function() {
                    const pathInput = document.getElementById('path');
                    const defaultPath = pathInput.value || './sk-content/upload/';

                    // 监听回退按钮点击事件
                    pathInput.addEventListener('keydown', (event) => {
                        // 如果按下的键是回车键
                        if (event.keyCode === 13) {
                            // 执行查询操作
                            if (pathInput.value === '') {
                                layer.msg('请输入内容');
                                return pathInput.focus();
                            }

                            const url = `/api/file/get?path=${pathInput.value}`;
                            table.reloadData('table', {
                                url
                            });
                            event.preventDefault();
                        }
                    });
                }
            });

            util.on({
                        'back': function() {
                            var value = pathInput.slice(pathInput.indexOf('.') + 1)
                            value = value.split('/')
                            console.log(value)
                        }
                    })

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