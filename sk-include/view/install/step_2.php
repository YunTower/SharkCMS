<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="icon" href="/sk-include/static/img/logo.png">
	<link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
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
	<p class="sk-copyright">
		<a target="_blank" href="https://www.sharkcms.cn">Powered by SharkCMS</a>
	</p>
	<!-- 资 源 引 入 -->
	<script src="/sk-include/static/js/axios.min.js"></script>
	<script src="/sk-admin/component/layui/layui.js"></script>
	<script src="/sk-admin/component/pear/pear.js"></script>
	<script src="/sk-include/static/js/sharkcms.min.js"></script>
	<script>
		layui.use(['form', 'popup', 'encrypt'], function() {
			var form = layui.form,
				popup = layui.popup,
				encrypt = layui.encrypt;

			// 提交事件
			form.on('submit(upload)', function(data) {
				var data = JSON.stringify(data.field);
				// base64 
				var data = encrypt.Base64Encode(data)
				// 配置axios拦截器
				axios.interceptors.request.use(config => {
					if (config.method === 'post') {
						config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
					}
					return config;
				});
				// 发送请求
				axios.post('/install/install/connect', {
						data: data
					})
					.then(function(response) {
						if (response.data.code == 200) {
							popup.success(response.data.msg, function() {
								window.location.href = '/install/step/3';
							})
						} else {
							if (response.data.code == 'undefined') {
								layer.alert(response.data, {
									'title': '安装错误'
								});

							} else {
								popup.failure(response.data.msg)
							}
						}
					})

				return false;
			});
		});
	</script>
</body>

</html>