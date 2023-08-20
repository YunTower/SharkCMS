<?php
if (@isset(json_decode(FrameWork::$_data)->from) && @json_decode(FrameWork::$_data)->from == 'article') {
    if ($_SERVER['REQUEST_URI'] != "/admin/login?from=article") header('Location:/admin/login?from=article');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登陆账号</title>
    <link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
    <link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
    <link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />
    <style>
        .title {
            text-align: center;
        }

        button {
            border-radius: 5px
        }
    </style>

</head>

<body class="layui-bg-gray body sk-form">
    <div class="layui-panel card" style="padding:25px;width:auto;border-radius: 3px">
        <div class="title">
            <h2 style="font-weight: 200">登陆</h2>
        </div>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-email"></i>
                    </div>
                    <input type="email" name="umail" value="test@test.test" lay-verify="required|email" placeholder="邮 箱" lay-reqtext="请填写邮箱" autocomplete="off" class="layui-input" lay-affix="clear">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-wrap">
                    <div class="layui-input-prefix">
                        <i class="layui-icon layui-icon-password"></i>
                    </div>
                    <input type="password" name="upwd" value="test" lay-verify="required" placeholder="密 码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-row">
                    <div class="layui-col-xs7">
                        <div class="layui-input-wrap">
                            <div class="layui-input-prefix">
                                <i class="layui-icon layui-icon-vercode"></i>
                            </div>
                            <input type="text" name="captcha" value="" lay-verify="required" placeholder="验证码" lay-reqtext="请填写验证码" autocomplete="off" class="layui-input" lay-affix="clear">
                        </div>
                    </div>
                    <div class="layui-col-xs5">
                        <div style="margin-left: 10px;">
                            <img src="/captcha/create" id="captcha" onclick="this.src='/captcha/create/'+ new Date().getTime();">
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="layui-form-item">
        <input type="checkbox" name="keep" lay-skin="primary" title="记住密码">
        <a href="/admin/reg" style="float: right; margin-top: 7px;">注册账号</a>
    </div> -->
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid pear-btn pear-btn-primary" lay-submit lay-filter="login">登录
                </button>
            </div>
            <div class="layui-form-item demo-login-other" style="text-align: center">
                <a href="/admin/reg">注册帐号</a>
            </div>
        </form>
    </div>

    <script src="/sk-include/static/js/axios.min.js"></script>
    <script src="/sk-include/static/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/sharkcms.min.js"></script>


    <script>
        layui.use(['form', 'layer', 'popup', 'encrypt'], function() {
            var form = layui.form,
                layer = layui.layer,
                popup = layui.popup,
                encrypt = layui.encrypt;

            // 提交事件
            form.on('submit(login)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));
                //  if uname 有特殊字符
                if (!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(data.uname)) {
                    layer.msg('【用户名】不能包含特殊字符', {
                        icon: 2
                    })
                } else {

                    // 提交登陆
                    axios.post('/api/login/' + new Date().getTime(), encrypt.Base64Encode(JSON.stringify(data)))
                        .then(function(response) {
                            if (response.data.code == 200) {
                                popup.success('登陆成功', function() {
                                    if (response.data.data.group == 'admin') {
                                        if (sk.getData()['from'] != undefined) {
                                            history.go(-1)

                                        } else {
                                            window.location.href = '/admin/index';
                                        }
                                    } else {
                                        history.go(-1)
                                    }

                                })
                            } else {
                                console.log(response.data)
                                if (response.data.code === 'undefind') {
                                    layer.alert(response.data.msg)
                                } else {
                                    popup.failure(response.data.msg)
                                }
                            }
                        })
                }
                return false;
            });
        });
    </script>
</body>

</html>