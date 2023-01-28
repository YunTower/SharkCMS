<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>500 - 服务器错误</title>
	<link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet" />
	<link href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/error.css" rel="stylesheet" />
</head>

<body>
	<div class="content">
		<img src="<?php echo sys_domain(); ?>/sk-admin/admin/images/500.svg" alt="">
		<div class="content-r">
			<h1>500</h1>
			<!-- <p>抱歉，服务器出错了</p> -->
			<p><?php echo $error_code ?></p>
			<a href="/">
				<button class="pear-btn pear-btn-primary">返回首页</button>
			</a>
		</div>
	</div>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
</body>

</html>