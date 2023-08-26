<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>设置</title>
    <link href="/sk-admin/component/pear/css/pear.css" rel="stylesheet">
    <link href="/sk-include/static/css/sharkcms.min.css" rel="stylesheet">

</head>

<body class="pear-container">
    <form class="layui-form" action="">
        <div class="layui-row layui-col-space10">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                            <ul class="layui-tab-title">
                                <li class="layui-this">网站设置</li>
                                <li>文章设置</li>
                                <li>用户设置</li>
                                <li>评论设置</li>
                                <li>系统设置</li>
                                <li>SEO设置</li>
                            </ul>

                            <!-- 网站 -->
                            <div class="layui-tab-content">
                                <div class="layui-tab-item layui-show">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">站点标题:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="Site-Title" placeholder="必填" value="<?= FrameWork::$getSetting['Site-Title'] ?>" lay-verify="required" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">站点副标题:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="Site-Subtitle" placeholder="必填" value="<?= FrameWork::$getSetting['Site-Subtitle'] ?>" lay-verify="required" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">站点图标:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="Site-Logo" placeholder="点击上传（支持：png/jpg/jpeg/webp" value="<?= FrameWork::$getSetting['Site-Logo'] ?>" id="UploadICON" lay-verify="required" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">自定义页头:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <textarea name="Site-HeaderCode" placeholder="将应用于所有页面【/head】标签前" value="<?= FrameWork::$getSetting['Site-HeaderCode'] ?>" class="layui-textarea"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">自定义页脚:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <textarea name="Site-FooterCode" placeholder="将应用于所有页面【/body】标签前" value="<?= FrameWork::$getSetting['Site-FooterCode'] ?>" class="layui-textarea"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 文章 -->
                                <div class="layui-tab-item">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">单页数量:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md2">
                                                <input type="number" name="Article-PageSize" placeholder="单页面显示数量（必填）" value="<?= FrameWork::$getSetting['Article-PageSize'] ?>" lay-verify="required|number" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">允许评论:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md3">
                                                <div class="layui-form" lay-filter="component-form-element">
                                                    <input type="checkbox" name="Article-AllowComment" lay-skin="switch" lay-text="开启|关闭" <?php if (FrameWork::$getSetting['Article-AllowComment']) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 用户 -->
                                <div class="layui-tab-item">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">允许注册:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md3">
                                                <div class="layui-form" lay-filter="component-form-element">
                                                    <input type="checkbox" name="User-AllowReg" lay-skin="switch" lay-text="开启|关闭" <?php if (FrameWork::$getSetting['User-AllowReg']) {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 评论 -->
                                <div class="layui-tab-item">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">评论审核:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md3">
                                                <div class="layui-form" lay-filter="component-form-element">
                                                    <input type="checkbox" name="Comment-Examined" lay-skin="switch" lay-text="开启|关闭" <?php if (FrameWork::$getSetting['Comment-Examined']) {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">登陆后评论:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md3">
                                                <div class="layui-form" lay-filter="component-form-element">
                                                    <input type="checkbox" name="Comment-PostLoginComments" lay-skin="switch" lay-text="开启|关闭" <?php if (FrameWork::$getSetting['Comment-PostLoginComments']) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">显示数量:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md2">
                                                <input type="number" name="Comment-PSize" placeholder="单页显示数量（必填）" value="<?= FrameWork::$getSetting['Comment-PSize'] ?>" lay-verify="required|number" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-tab-item">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">API Key:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="" value="<?= FrameWork::$_App['api']['Key'] ?>" autocomplete="off" class="layui-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">API Token:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="" value="<?= FrameWork::$_App['api']['Token'] ?>" autocomplete="off" class="layui-input" disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- SEO设置 -->
                                <div class="layui-tab-item">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">站点关键词:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="Seo-Keyword" placeholder="请输入关键词（多个关键词请使用英文逗号分割，必填）" value="<?= FrameWork::$getSetting['Seo-Keyword'] ?>" lay-verify="required" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">站点描述:</label>
                                        <div class="layui-input-block">
                                            <div class="layui-col-md6">
                                                <input type="text" name="Seo-Description" placeholder="请输入描述（必填）" value="<?= FrameWork::$getSetting['Seo-Description'] ?>" lay-verify="required" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-md6">
                                    <div class="sk-center">
                                        <button plain class="pear-btn pear-btn-primary" style="width:30%" lay-submit lay-filter="setting">保存设置</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="/sk-admin/component/layui/layui.js"></script>
    <script src="/sk-admin/component/pear/pear.js"></script>
    <script src="/sk-include/static/js/axios.min.js"></script>
    <script>
        layui.use(['form', 'element', 'layer', 'encrypt', 'upload'], function() {
            var form = layui.form,
                layer = layui.layer,
                element = layui.element,
                encrypt = layui.encrypt,
                upload = layui.upload;

            upload.render({
                elem: '#UploadICON',
                url: '/api/upload/SiteIcon',
                accept: 'image',
                done: function(res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {icon: 1});
                        var value=document.getElementById('UploadICON');
                        value.value=res.data.url;
                    }else{
                        layer.msg(res.msg, {icon: 2});
                    }
                }
            });

            // 提交事件
            form.on('submit(setting)', function(data) {
                var data = JSON.parse(JSON.stringify(data.field));
                console.log(data);


                // 提交登陆
                axios.post('/api/SaveSetting', encrypt.Base64Encode(JSON.stringify(data)))
                    .then(function(response) {
                        console.log(response.data)

                        if (response.data.code == 200) {

                        } else {
                            console.log(response.data)

                        }
                    })

                return false;
            });
        });
    </script>
</body>

</html>