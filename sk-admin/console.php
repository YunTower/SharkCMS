<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>控制台</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />

	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/console2.css" />
</head>

<body class="pear-container">
	<div class="layui-row layui-col-space10">
		<div class="layui-col-md8">
			<div class="layui-row layui-col-space10">
				<div class="layui-col-md6">
					<div class="layui-card">
						<div class="layui-card-header">
							快捷菜单
						</div>
						<div class="layui-card-body">
							<div class="layui-row layui-col-space10">
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home1" data-title="主页" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-edit"></i>
									</div>
									<span class="pear-card-title">攥写文章</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home2" data-title="弹层" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-file"></i>
									</div>
									<span class="pear-card-title">文章管理</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home2" data-title="聊天" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-comment"></i>
									</div>
									<span class="pear-card-title">评论管理</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home3" data-title="相机" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-layout"></i>
									</div>
									<span class="pear-card-title">主题设置</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home4" data-title="表单" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-setting"></i>
									</div>
									<span class="pear-card-title">系统设置</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home5" data-title="安全" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-upload"></i>
									</div>
									<span class="pear-card-title">检查更新</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home6" data-title="公告" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-image-text"></i>
									</div>
									<span class="pear-card-title">官方网站</span>
								</div>
								<div class="layui-col-md3-top layui-col-sm3 layui-col-xs3">
									<div class="pear-card" data-id="home7" data-title="更多" data-url="http://www.baidu.com">
										<i class="icon pear-icon pear-icon-help"></i>
									</div>
									<span class="pear-card-title">官方文档</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="layui-col-md6">
					<div class="layui-card">
						<div class="layui-card-header">
							系统统计
						</div>
						<div class="layui-card-body">
							<div class="layui-row layui-col-space10">
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">文章总数</div>
										<div class="count pear-text">1</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">评论总数</div>
										<div class="count pear-text">0</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">菜单总数</div>
										<div class="count pear-text">3</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">页面总数</div>
										<div class="count pear-text">3</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="layui-col-md12">
					<div class="layui-card">
						<div class="layui-card-header">
							最近动态
						</div>
						<div class="layui-card-body">
							<table id="role-table" lay-filter="role-table"></table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="layui-col-md4">
			<div class="layui-card">
				<div class="layui-card-header">系统信息</div>
				<div class="layui-card-body">
					<table class="layui-table">
						<tr>
							<td>系统名称</td>
							<td><?php echo App_N ?></td>
						</tr>
						<tr>
							<td>系统版本</td>
							<td><?php echo App_V ?></td>
						</tr>
						<tr>
							<td>版本类型</td>
							<td>
								<?php
								if (App_T=='release'){
									echo'发行版';
								} else if(App_T=='demo'){
									echo'演示版';
								} else if(App_T=='beta'){
									echo '测试版';
								} else if(App_T=='dev'){
									echo '开发版';
								} else if(App_T=='rc'){
									echo '预发布版';
								} else{
									echo'未知版本';
								}
								?>
							</td>
						</tr>

						<tr>
							<td>PHP版本</td>
							<td><?php echo PHP_VERSION ?></td>
						</tr>
						<tr>
							<td>解释引擎</td>
							<td><?php if (!isset($_SERVER['SERVER_SOFTWARE'])) {
									echo '未检测到解释引擎类型';
								}
								$webServer = strtolower($_SERVER['SERVER_SOFTWARE']);
								if (strpos($webServer, 'apache') !== false) {
									echo 'Apache';
								} elseif (strpos($webServer, 'microsoft-iis') !== false) {
									echo 'IIS';
								} elseif (strpos($webServer, 'nginx') !== false) {
									echo 'Nginx';
								} elseif (strpos($webServer, 'lighttpd') !== false) {
									echo 'Lighttpd';
								} elseif (strpos($webServer, 'kangle') !== false) {
									echo 'Kangle';
								} elseif (strpos($webServer, 'caddy') !== false) {
									echo 'Saddy';
								}else {
									echo $webServer;
								} ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="layui-card">
				<div class="layui-card-header">系统公告</div>
				<div class="layui-card-body">
					<ul class="list">
						<li class="list-item">
							<span class="title">SharkCMS 1.0.0内测版上线</span>
							<span class="footer">2023-02-01</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--</div>-->
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['layer', 'carousel', 'table'], function() {
			var $ = layui.jquery,
				layer = layui.layer,
				table = layui.table,
				carousel = layui.carousel;

				// 版本更新检查
				sys_check()
				function sys_check() {
                $.ajax({
                    url: "https://api.sharkcms.cn/update/<?php echo App_T ?>/check.php?v=<?php echo App_V ?>&d=<?php echo sys_domain() ?>&t=<?php echo time() ?>",
                    type: "GET",
                    dataType: "jsonp",
                    jsonp: "callback",
                    success: function(data) {
                        layer.alert(data.msg)
                    }
                })
            }
			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: '用户名',
						field: 'uname',
						align: 'center',
						width: 100
					},
					{
						title: '操作内容',
						field: 'content',
						align: 'center',
						templet: '#role-enable'
					},
					{
						title: '操作时间',
						field: 'time',
						align: 'center',

					}
				]
			]

			table.render({
				elem: '#role-table',
				url: '../../sk-admin/admin/data/role.json',
				page: true,
				cols: cols,
				skin: 'line'
			});
		});
	</script>
</body>

</html>