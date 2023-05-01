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
	<form class="layui-form-install" action="../../index.php/sk-install/install" method="POST" style="margin-top: 0;">
		<div class="layui-form-item">
			<img class="logo"/>
			<div class="title">SharkCMS</div>
			<div class="desc">
				一 起 创 造 属 于 你 的 世 界！
			</div>
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库地址" value="127.0.0.1" name="dbhost" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库名称" value="" name="dbname" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库账号" value="" name="dbuser" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库密码" value="" name="dbpwd" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="email" placeholder="管理员邮箱" value="" name="adminmail" lay-verify="required" hover class="layui-input" id="mail" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="管理员昵称" value="" name="adminname" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="password" placeholder="管理员密码" id="pwd" value="" name="adminpwd" lay-verify="required" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<button class="pear-btn pear-btn-success login" lay-submit lay-filter="login">
				快速安装
			</button>
		</div>
	</form>
	<!-- 资 源 引 入 -->
	<script src="<?php echo Route::Domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo Route::Domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		document.onreadystatechange = function() {
			if (document.readyState == 'complete') {
				layer.open({
					type: 2,
					title: 'SharkCMS 环境检查',
					String: 1,
					area: ['75%', '70%'],
					content: 'https://api.sharkcms.cn/tips.php'
				});
			}
		}
		layui.use(['form', 'button', 'popup'], function() {
			var form = layui.form;
			var button = layui.button;
			var popup = layui.popup;

			// 登 录 提 交
			form.on('submit(login)', function() {
				var mail = $('#mail').val();
				var pwd = $('#pwd').val();

				// 验证
				if (mail.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)) {
					if (pwd.length < 6) {
						layer.alert("【管理员密码】不得少于6位！");
						return false
					} else {
						layer.msg('请求安装中...')
					}
				} else {
					layer.alert('【邮箱】格式不合法！')
					return false
				}
			});
		})
	</script>
</body>

</html>