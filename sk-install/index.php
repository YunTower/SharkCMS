<?php
$config = include_once INC . 'config.php';
if (@$config['INSTALL'] != null) {
	sys_error('安装已锁定', '系统已安装成功，无需再次安装<br>如需再次安装，请手动清空“/sk-include/config.php”文件');
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="<?php echo Route::Domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo Route::Domain(); ?>/sk-admin/admin/css/other/login.css" />
</head>
<!-- 代 码 结 构 -->

<body background="<?php echo Route::Domain(); ?>/sk-admin/admin/images/background.svg" style="background-size: cover;">
	<form class="layui-form-install" onsubmit="return false" method="POST" style="margin-top: 0;" lay-filter="form-demo-submit">
		<div class="layui-form-item">
			<img class="logo" />
			<div class="title">SharkCMS</div>
			<div class="desc">
				一 起 创 造 属 于 你 的 世 界！
			</div>
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库地址" value="127.0.0.1" name="dbhost" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库名称" value="test" name="dbname" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库账号" value="test" name="dbuser" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库密码" value="testtest" name="dbpwd" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="email" placeholder="管理员邮箱" value="test@test.test" name="adminmail" lay-verify="required" hover class="layui-input" id="mail" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="管理员昵称" value="test" name="adminname" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="password" placeholder="管理员密码" id="pwd" value="testtest" name="adminpwd" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<button class="pear-btn pear-btn-success login" id="login">
				快速安装
			</button>
		</div>
	</form>
	<!-- 资 源 引 入 -->
	<script src="<?php echo Route::Domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo Route::Domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(function() {
			var form = layui.form;
			var button = layui.button;
			var popup = layui.popup;
			var $ = layui.jquery;

			$('#test-btn-submit').on('click', function() {
				form.submit('form-demo-submit', function(data) {
					var field = data.field; // 获取表单全部字段值
					console.log(data); // 回调函数返回的 data 参数和提交事件中返回的一致
					// 执行提交
					layer.confirm('确定提交吗？', function(index) {
						layer.close(index); // 关闭确认提示框
						// 显示填写结果，仅作演示用
						layer.alert(JSON.stringify(field), {
							title: '当前填写的字段值'
						});
						// 此处可执行 Ajax 等操作
						// …
					});
				});
				return false;
			});
		})
	</script>
</body>

</html>