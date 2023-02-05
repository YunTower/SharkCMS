<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/login.css" />
</head>
<!-- 代 码 结 构 -->

<body background="<?php echo sys_domain(); ?>/sk-admin/admin/images/background.svg" style="background-size: cover;">
	<form class="layui-form-install" action="../../index.php/sk-install/install" method="POST" style="margin-top: 0;">
		<div class="layui-form-item">
			<img class="logo" src="<?php echo sys_domain(); ?>/sk-admin/admin/images/logo.png" />
			<div class="title">SharkCMS</div>
			<div class="desc">
				一 起 创 造 属 于 你 的 世 界！
			</div>
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="数据库地址" value="" name="dbhost" lay-verify="required" hover class="layui-input" />
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
			<input type="email" placeholder="管理员邮箱" id="mail" value="" name="adminmail" lay-verify="required|email" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="text" placeholder="管理员账号" value="" name="adminname" lay-verify="required" hover class="layui-input" />
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
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		document.onreadystatechange = function() {
      if (document.readyState == 'complete') {
        layer.open({
          type: 2,
          title: 'SharkCMS 环境检查',
          String: 1,
          area: ['75%', '70%'],
          content: 'sk-install/tips.php'
        });
      }
    }
	</script>
</body>

</html>