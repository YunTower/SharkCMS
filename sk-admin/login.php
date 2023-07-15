<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>登陆账号</title>
	<link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
	<link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />
	<style>
		.title {
			text-align: center;
		}
	</style>

</head>

<body class="layui-bg-gray body sk-form">
	<div class="layui-panel card" style="padding:25px;width:auto;">
		<div class="title">
			<h2 style="font-weight: 200">登陆</h2>
		</div>
		<form class="layui-form" method="POST" action="">
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
					<input type="password" name="upwd" value="testtest" lay-verify="required" placeholder="密 码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
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
				<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login">登录</button>
			</div>
			<div class="layui-form-item demo-login-other" style="text-align: center">
				<a href="/admin/reg">注册帐号</a>
			</div>
		</form>
	</div>

	<script src="/sk-include/static/js/jquery.min.js"></script>
	<script src="/sk-include/static/layui/layui.js"></script>
	<script src="/sk-include/static/js/sharkcms.min.js"></script>
	<script>
		layui.use(function() {
			var form = layui.form;
			var layer = layui.layer;
			// 提交事件
			form.on('submit(login)', function(data) {
				var data = JSON.parse(JSON.stringify(data.field));
				//  if uname 有特殊字符
				if (!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(data.uname)) {
					layer.msg('【用户名】不能包含特殊字符', {
						icon: 2
					})
				} else {

					// ajax请求
					// console.log(data)
					$.ajax({
						type: 'POST',
						url: '/api/login/' + new Date().getTime(),
						dataType: "json",
						data: Base64.encode(JSON.stringify(data)),
						contentType: "application/jsoan",
						success: function(data) {
							// 加载动画
							var loadIndex = layer.msg('登陆中', {
								icon: 16,
								shade: 0.01
							});

							// 连接状态
							if (data.code == 200) {
								// if 200 ==> 弹出层 && 跳转 /admin/index
								layer.close(loadIndex)
								layer.msg('登陆成功', {
									time: 5 * 1000,
									icon: 1
								});
								window.location.href = '/admin/index';
							} else {
								// 刷新验证码
								var captcha = document.getElementById("captcha");
								captcha.src = '/captcha/create/' + new Date().getTime();
								// 弹出层
								layer.close(loadIndex)
								layer.alert(data.msg, {
									title: '登陆失败',
									icon: '2'
								})

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