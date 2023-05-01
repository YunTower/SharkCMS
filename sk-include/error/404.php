<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>404 - 资源不存在</title>
	<link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet" />
	<link href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/error.css" rel="stylesheet" />
</head>

<body>
	<div class="content">
		<img src="<?php echo sys_domain(); ?>/sk-admin/admin/images/404.svg" alt="">
		<div class="content-r">
			<h1>404</h1>
			<p>抱歉，你访问的页面不存在</p>
			<a href="/">
				<button class="pear-btn pear-btn-primary">返回首页</button>
			</a>
		</div>
	</div>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
</body>

</html>