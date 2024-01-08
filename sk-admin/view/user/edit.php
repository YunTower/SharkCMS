<?php

use FrameWork\User\User;

if (isset($_GET['uid'])) {
    if (is_numeric(htmlspecialchars($_GET['uid']))) $uid = htmlspecialchars($_GET['uid']);
    $data = User::getInfo($uid);
    if (empty($data)) {
        FrameWork\FrameWork::WARNING(404);
    }
} else {
    FrameWork\FrameWork::WARNING(403);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>修改</title>
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />

</head>

<body>
    <form class="layui-form" action="">
        <div class="mainBox">
            <div class="main-container">
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                头像
                            </div>
                            <input type="text" name="avatar" title="点击上传" placeholder="点击上传头像" value="<?= $data['avatar'] ?>" id="Avatar" class="layui-input">
                            <div class="layui-input-split layui-input-suffix" style="color: #2d8cf0;" id="Preview" lay-on="preview">
                                预览
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                用户名
                            </div>
                            <input type="text" name="name" placeholder="" lay-verify="required" value="<?= $data['name'] ?>" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                邮箱
                            </div>
                            <input type="email" name="mail" placeholder="" lay-verify="required|email" value="<?= $data['mail'] ?>" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                角色
                            </div>
                            <select name="role" lay-verify="">
                                <option value="admin" <?php if (User::$userRole=='admin') echo 'clected' ?>>Admin</option>
                                <option value="user" <?php if (User::$userRole=='user') echo 'clected' ?>>User</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                状态
                            </div>
                            <select name="ban" lay-verify="">
                                <option value="false" <?php if (!User::is_ban()) echo 'clected' ?>>启用</option>
                                <option value="true" <?php if (User::is_ban()) echo 'clected' ?>>禁用</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-item">
                        <div class="layui-input-group">
                            <div class="layui-input-split layui-input-prefix">
                                新密码
                            </div>
                            <input type="password" name="pwd" placeholder="留空则不重置密码" class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="button-container">
                <button type="submit" class="pear-btn pear-btn-primary pear-btn-sm" lay-submit="" lay-filter="save" load>
                    <i class="layui-icon layui-icon-ok"></i>
                    提交
                </button>
                <button type="reset" class="pear-btn pear-btn-sm" lay-on="close">
                    取消
                </button>
            </div>
        </div>
    </form>
    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>
    <script>
        layui.use(['form', 'layer', 'util', 'button', 'encrypt', 'upload'], function() {
            var form = layui.form,
                layer = layui.layer,
                button = layui.button,
                util = layui.util,
                upload = layui.upload,
                encrypt = layui.encrypt;
            // 设置默认头像
            var DefaultAvatar = '/sk-content/upload/avatar/default.jpg';
            // 获取头像路径
            var src = document.getElementById('Avatar').value;
            // 若未设置头像，则使用默认头像
            if (src == '') {
                src = DefaultAvatar
                document.getElementById('Avatar').value = DefaultAvatar
            }

            util.on('lay-on', {
                // 关闭当前窗口
                'close': function() {
                    var index = parent.layer.getFrameIndex(window.name); // 获取当前 iframe 层的索引
                    parent.layer.close(index); // 关闭当前 iframe 弹层
                },
                // 预览头像
                'preview': function() {
                    layer.photos({
                        photos: {
                            "title": "图片查看器",
                            "start": 0,
                            "data": [{
                                "src": src,
                            }]
                        }
                    });
                }
            })

            // 头像上传
            upload.render({
                elem: '#Avatar',
                url: '/api/upload?file=image&type=avatar',
                accept: 'image',
                done: function(res, index, upload) {
                    console.log(res)
                    if (res.code == 200) {
                        layer.msg(res.msg, {
                            icon: 1
                        });
                        var upload = document.getElementById('Avatar')
                        upload.value = res.data.url;
                    } else {
                        layer.msg(res.msg, {
                            icon: 2
                        });
                    }
                }
            });


            // 表单提交事件
            form.on('submit(save)', function(data) {
                var data = JSON.stringify(data.field);

                // 按钮动画开始
                var load = button.load({
                    elem: '[load]',
                })

                // 配置axios拦截器
                axios.interceptors.request.use(config => {
                    if (config.method === 'post') {
                        config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
                    }
                    return config;
                });


                // 提交数据
                var uid = sk.getData()['uid']
                var data = encrypt.Base64Encode(data)
                axios.post('/api/user/update?uid=' + uid, {
                        data: data
                    })
                    .then(function(response) {
                        if (response.data.code == 200) {
                            layer.msg(response.data.msg, {
                                icon: 1
                            });
                            // 按钮动画停止
                            load.stop()
                            sk.sleep(1000).then(() => {
                                var index = parent.layer.getFrameIndex(window.name); // 获取当前 iframe 层的索引
                                parent.layer.close(index); // 关闭当前 iframe 弹层
                            })
                        } else {

                            layer.alert(response.data.msg, {
                                title: '保存失败',
                                icon: 2
                            })
                            load.stop()
                        }
                    })

                return false;
            });
        })
    </script>
    <script>
    </script>
</body>

</html>