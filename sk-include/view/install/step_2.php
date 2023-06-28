<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
	<link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />

</head>

<body class="layui-bg-gray sk-form">
	<div class="layui-panel card">
		<form class="layui-form layui-form-pane" action="">
			<div class="layui-form-item">
				<label class="layui-form-label">管理员名字</label>
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
				<button type="button" style="width:200px;height:35px" class="layui-btn layui-btn-primary layui-btn-sm" lay-submit lay-filter="upload">提交</button>
			</div>
		</form>
	</div>
	<!-- 资 源 引 入 -->
	<script src="/sk-include/static/js/jquery.min.js"></script>
	<script src="/sk-include/static/layui/layui.js"></script>
	<script src="/sk-include/static/js/sharkcms.base64.js"></script>
	<script>
		layui.use(['form'], function() {
			var form = layui.form;
			var layer = layui.layer;
			// 提交事件
			form.on('submit(upload)', function(data) {
				var data = JSON.stringify(data.field);
				if (JSON.parse(data).ad_pwd != JSON.parse(data).ad_pwd_) {
					layer.msg('两次输入的密码不一致', {
						icon: '2'
					})
				} else {
					// base64 加密传输
					var data = Base64.encode(data)
					// ajax请求
					$.ajax({
						type: 'POST',
						url: '/install/install/install',
						dataType: "json",
						data: data,
						contentType: "application/jsoan",
						success: function(data) {
							// 连接状态
							if (data.code == 1000) {
								// if 1000 ==> 弹出层 && 跳转 /install/step/3
								layer.msg('安装成功', {
									time: 5 * 1000,
									icon: 1
								});
								window.location.href = '/install/step/3';
							} else {
								// 弹出层
								layer.alert(data.msg, {
									title: '安装失败',
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