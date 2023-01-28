<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>登录</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/login.css" />
</head>
<!-- 代 码 结 构 -->

<body background="<?php echo sys_domain(); ?>/sk-admin/admin/images/background.svg" style="background-size: cover;">
	<form class="layui-form" action="javascript:void(0);">
		<div class="layui-form-item">
			<img class="logo" src="<?php echo sys_domain(); ?>/sk-admin/admin/images/logo.png" />
			<div class="title">SharkCMS</div>
			<div class="desc">
				登 陆 账 号
			</div>
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="账号" value="test" id="user" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="password" placeholder="密码" value="testtest" id="pwd" lay-verify="required" hover class="layui-input" />
		</div>
		<!-- <div class="layui-form-item">
				<input placeholder="验证码 : "  hover  lay-verify="required" class="code layui-input layui-input-inline"  />
				<img src="<?php echo sys_domain(); ?>/sk-admin/admin/images/captcha.gif" class="codeImage" />
			</div> -->
		<div class="layui-form-item">
			<input type="checkbox" name="" title="记住密码" lay-skin="primary" checked>
		</div>
		<div class="layui-form-item">
			<button type="button" class="pear-btn pear-btn-success login" lay-submit lay-filter="login">
				登 陆
			</button>
		</div>
	</form>
	<!-- 资 源 引 入 -->
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['form', 'button', 'popup'], function() {
			var form = layui.form;
			var button = layui.button;
			var popup = layui.popup;

			// 登 录 提 交
			form.on('submit(login)', function() {
				var user = $('#user').val();
				var pwd = $('#pwd').val();
					if (pwd.length < 6) {
						layer.alert("【管理员密码】少于6位！");
						return false
					} else {
						layer.msg('登陆请求中')
						var data = JSON.stringify({
							user: user,
							pwd: pwd
						});
						$.ajax({
							type: "POST",
							url: "<?php sys_domain(); ?>/index.php/sk-include/api?action=login",
							dataType: "json",
							data: data,
							contentType: "application/jsoan",
							success: function(data) {
								var obj = JSON.parse(JSON.stringify(data));

								// 输出消息
								console.log(obj.msg);
								layer.alert(obj.msg);
								var status = obj.status;
								if (status == "ok") {
									button.load({
										elem: '.login',
										time: 1500,
										done: function() {
											popup.success("登录成功", function() {
												location.href = "index.html"
											});
										}
									})
								}
							},
						});
					}
				
			});
		})
	</script>
</body>

</html>