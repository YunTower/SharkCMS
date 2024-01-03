<?php

use FrameWork\FrameWork;
use FrameWork\View\View;

function data()
{
    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'edit') {
        $id = htmlentities($_GET['id']);
        return View::find('sk_category', ['id', $id]);
    }
}
function _edit()
{
    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'edit') {
        if (empty(data())) {
            FrameWork::WARNING(0, ['系统错误', '文章不存在']);
            exit;
        }
        return data()[0];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>添加 / 修改 分类</title>
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
                                标签名
                            </div>
                            <input type="text" name="name" placeholder="" lay-verify="required" value="<?php if (_edit() && _edit()['name']) echo _edit()['name'] ?>" class="layui-input">
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
        layui.use(['form', 'layer', 'button', 'encrypt', 'util'], function() {
            var form = layui.form,
                layer = layui.layer,
                button = layui.button,
                util = layui.util,
                encrypt = layui.encrypt;
            var request_url = '/api/category/add';
            if (sk.getData()['action'] == 'edit') {
                var request_url = '/api/category/edit';
            }

            util.on('lay-on', {
                // 关闭当前窗口
                'close': function() {
                    var index = parent.layer.getFrameIndex(window.name); // 获取当前 iframe 层的索引
                    parent.layer.close(index); // 关闭当前 iframe 弹层
                }
            })

            // 表单提交事件
            form.on('submit(save)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));

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
                axios.post(request_url + "?id=" + sk.getData()['id'], data)
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