<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="icon" href="/sk-include/static/img/logo.png">
	<link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
	<link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />

</head>

<body class="layui-bg-gray sk-form">
	<div class="layui-panel card">
		<form class="layui-form layui-form-pane" action="">
			<div class="layui-form-item">
				<label class="layui-form-label">管理员昵称</label>
				<div class="layui-input-block">
					<input type="text" value="test" name="ad_name" autocomplete="off" placeholder="请输入" value="127.0.0.1" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">管理员邮箱</label>
				<div class="layui-input-block">
					<input type="email" value="test@test.test" name="ad_mail" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">管理员密码</label>
				<div class="layui-input-block">
					<input type="password" value="test" name="ad_pwd" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">重复密码</label>
				<div class="layui-input-block">
					<input type="password" value="test" name="ad_pwd_" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
				</div>
			</div>

			<div class="layui-form-item button-item button-next">
				<button type="button" style="width:200px;height:35px" class="layui-btn layui-btn-primary layui-btn-sm" lay-submit lay-filter="upload" load>提交</button>
			</div>
		</form>
	</div>
	<p class="sk-copyright">
		<a target="_blank" href="https://www.sharkcms.cn">Powered by SharkCMS</a>
	</p>
	<!-- 资 源 引 入 -->
	<script src="/sk-include/static/js/axios.min.js"></script>
	<script src="/sk-include/static/layui/layui.js"></script>
	<script src="/sk-admin/component/pear/pear.js"></script>
	<script src="/sk-include/static/js/sharkcms.min.js"></script>
	<script>
		layui.use(['form', 'layer', 'popup', 'button', 'loading'], function() {
			var form = layui.form,
				layer = layui.layer,
				popup = layui.popup,
				button = layui.button,
				loading = layui.loading;

			// 提交事件
			form.on('submit(upload)', function(data) {
				var data = JSON.stringify(data.field);
				if (JSON.parse(data).ad_pwd != JSON.parse(data).ad_pwd_) {
					layer.msg('两次输入的密码不一致', {
						icon: '2'
					})
				} else {
					// 按钮加载效果
					var load = button.load({
						elem: '[load]',
					})
					loading.block({
						type: 1,
						elem: '.card',
						msg: '安装中'
					})
					// base64 加密传输
					var data = Base64.encode(data)
					// 发送请求
					axios.post('/install/install/install', data)
						.then(function(response) {
							if (response.data.code == 200) {
								load.stop()
								loading.blockRemove(".card", 0);
								popup.success(response.data.msg, function() {
									window.location.href = '/install/step/3';
								})
							} else {
								load.stop()
								loading.blockRemove(".card", 0);
								layer.alert(response.data.msg, {
									title: '安装错误',
									icon: 2
								});

							}
						})

				}
				return false;
			});
		});
	</script>
</body>

</html>