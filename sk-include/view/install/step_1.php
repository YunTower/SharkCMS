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
				<label class="layui-form-label">数据库地址</label>
				<div class="layui-input-block">
					<input type="text" name="db_host" autocomplete="off" placeholder="请输入" value="127.0.0.1" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">数据库名称</label>
				<div class="layui-input-block">
					<input type="text" name="db_name" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">数据库账号</label>
				<div class="layui-input-block">
					<input type="text" name="db_user" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">数据库密码</label>
				<div class="layui-input-block">
					<input type="text" name="db_pwd" autocomplete="off" placeholder="请输入" lay-verify="required" class="layui-input">
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
	<script src="/sk-include/static/js/sharkcms.min.js"></script>
	<script>
		layui.use(['form'], function() {
			var form = layui.form;
			var layer = layui.layer;
			// 提交事件
			form.on('submit(upload)', function(data) {
				var data = JSON.stringify(data.field);
				// base64 加密传输
				var data = Base64.encode(data)
				// ajax请求
				$.ajax({
					type: 'POST',
					url: '/install/install/connect',
					dataType: "json",
					data: data,
					contentType: "application/jsoan",
					success: function(data) {
						// 连接状态
						if (data.code == 200) {
							// if 1000 ==> 弹出层 && 跳转 /install/step/2
							layer.msg('数据库连接成功', {
								time: 5 * 1000,
								icon: 1
							});
							window.location.href = '/install/step/2';
						} else {
							// 弹出层
							layer.alert(data.error, {
								title: '数据库连接错误',
								icon: '2'
							})
						}
					}
				})
				return false;
			});
		});
	</script>
</body>

</html>