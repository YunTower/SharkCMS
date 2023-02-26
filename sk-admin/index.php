<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>后台 - SharkCMS内容管理系统</title>
	<link rel="alternate icon" href="<?php echo sys_domain(); ?>/sk-include/static/img/logo.png" type="image/png">
	<!-- 依 赖 样 式 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<!-- 加 载 样 式 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/loader.css" />
	<!-- 布 局 样 式 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/admin.css" />
</head>
<!-- 结 构 代 码 -->

<body class="layui-layout-body pear-admin">
	<!-- 布 局 框 架 -->
	<div class="layui-layout layui-layout-admin">
		<!-- 顶 部 样 式 -->
		<div class="layui-header">
			<!-- 菜 单 顶 部 -->
			<div class="layui-logo">
				<!-- 图 标 -->
				<img class="logo">
				<!-- 标 题 -->
				<span class="title"></span>
			</div>
			<!-- 顶 部 左 侧 功 能 -->
			<ul class="layui-nav layui-layout-left">
				<li class="collapse layui-nav-item"><a href="#" class="layui-icon layui-icon-shrink-right"></a></li>
				<li class="refresh layui-nav-item"><a href="#" class="layui-icon layui-icon-refresh-1" loading=600></a></li>
			</ul>
			<!-- 多 系 统 菜 单 -->
			<div id="control" class="layui-layout-control"></div>
			<!-- 顶 部 右 侧 菜 单 -->
			<ul class="layui-nav layui-layout-right">
				<li class="layui-nav-item layui-hide-xs"><a href="#" class="menuSearch layui-icon layui-icon-search"></a></li>
				<li class="layui-nav-item layui-hide-xs"><a href="#" class="fullScreen layui-icon layui-icon-screen-full"></a></li>
				<li class="layui-nav-item layui-hide-xs"><a target="_blank" href="https://sharkcms.cn/" class="layui-icon layui-icon-website"></a></li>
				<!--系统通知组件 开发中-->
				<!-- <li class="layui-nav-item layui-hide-xs message"></li> -->
				<li class="layui-nav-item user">
					<!-- 头 像 -->
					<a class="layui-icon layui-icon-username" href="javascript:;"></a>
					<!-- 功 能 菜 单 -->
					<dl class="layui-nav-child" style="text-align:center">
						<dd><a user-menu-title="<?php echo admin_user_name(); ?>"><?php echo admin_user_name(); ?></a></dd>
						<dd><a user-menu-url="view/system/person.html" user-menu-id="5555" user-menu-title="基本资料">基本资料</a></dd>
						<dd><a href="javascript:void(0);" class="logout">退出登录</a></dd>
					</dl>
				</li>
				<!-- 主 题 配 置 -->
				<li class="layui-nav-item setting"><a href="#" class="layui-icon layui-icon-more-vertical"></a></li>
			</ul>
		</div>
		<!-- 侧 边 区 域 -->
		<div class="layui-side layui-bg-black">
			<!-- 菜 单 顶 部 -->
			<div class="layui-logo">
				<!-- 图 标 -->
				<img class="logo">
				<!-- 标 题 -->
				<span class="title"></span>
			</div>
			<!-- 菜 单 内 容 -->
			<div class="layui-side-scroll">
				<div id="sideMenu"></div>
			</div>
		</div>
		<!-- 视 图 页 面 -->
		<div class="layui-body">
			<!-- 内 容 页 面 -->
			<div id="content"></div>
		</div>
		<!-- 页脚 -->
		<div class="layui-footer layui-text">
			<span class="left">
				Released under the MIT license.
			</span>
			<span class="center"></span>
			<span class="right">
				<?php
				$start = "2023";
				$now = date('Y');
				if ($start == $now) {
					echo "Copyright © $start <a href='https://sharkcms.cn'>sharkcms.cn</a>";
				} else {
					echo "Copyright © $start-$now <a href='https://sharkcms.cn'>sharkcms.cn</a>";
				}
				?>
			</span>
		</div>
		<!-- 遮 盖 层 -->
		<div class="pear-cover"></div>
		<!-- 加 载 动 画 -->
		<div class="loader-main">
			<!-- 动 画 对 象 -->
			<div class="loader"></div>
		</div>
	</div>
	<!-- 移 动 端 便 捷 操 作 -->
	<div class="pear-collapsed-pe collapse">
		<a href="#" class="layui-icon layui-icon-shrink-right"></a>
	</div>
	<!-- 依 赖 脚 本 -->
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-include/static/js/sharkcms.min.js"></script>
	<!-- 框 架 初 始 化 -->
	<script>
		layui.use(['admin', 'jquery', 'popup'], function() {
			var $ = layui.jquery,
				admin = layui.admin,
				popup = layui.popup,
				layer = layui.layer,
				table = layui.table,
				carousel = layui.carousel,
				key = '<?php get_key() ?>',
				domain = '';

			$.ajax({
				url: "../../index.php/sk-include/api?action=site_info",
				headers: {
					'Content-Type': 'application/json;charset=utf8',
					'key': key
				},
				type: "GET",
				success: function(data) {
					var obj = JSON.parse(data);

					domain = obj.domain
				}
			})

			admin.setConfigType("yml");
			admin.setConfigPath("<?php echo sys_domain(); ?>/sk-admin/config/pear.config.yml");

			admin.render();

			// 登出逻辑 
			admin.logout(function() {
				popup.success("注销成功", function() {
					location.href = "<?php echo sys_domain(); ?>/index.php/sk-admin/login";
				})
				// 注销逻辑 返回 true / false
				return true;
			})


			setInterval(function() {
				$.ajax({
					url: domain + "/index.php/sk-include/api?action=status",
					type: "POST",
					async: false,
					headers: {
						'Content-Type': 'application/json;charset=utf8',
						'key': key
					},
					success: function(data) {
						var obj = JSON.parse(data)
						if (obj.login == false) {
							console.log(obj)
							alert('登陆状态已失效，请重新登陆')
							window.location.href = domain + '/index.php/sk-admin/login'
							return false
						}
					}
				})
			}, 50000)
		})
	</script>
</body>

</html>