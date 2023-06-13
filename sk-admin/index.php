<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>SharkCMS 后台管理</title>
	<link rel="icon" type="image/svg+xml" href="/sk-include/static/img/logo.png" />
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
	<link rel="stylesheet" href="/sk-include/static/css/remixicon.css" />
	<link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />
	<script src="/sk-include/static/layui/layui.js"></script>


</head>

<body>
	<div class="layui-layout layui-layout-admin">
		<div class="layui-header">
			<div class="layui-logo layui-hide-xs layui-bg-black">SharkCMS</div>
			<!-- 头部区域（可配合layui 已有的水平导航） -->
			<ul class="layui-nav layui-layout-left">
				<!-- 移动端显示 -->
				<li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
					<i class="layui-icon layui-icon-spread-left"></i>
				</li>
				<li class="layui-nav-item layui-hide-xs"><a href="javascript:;">nav 1</a></li>
				<li class="layui-nav-item layui-hide-xs"><a href="javascript:;">nav 2</a></li>
				<li class="layui-nav-item layui-hide-xs"><a href="javascript:;">nav 3</a></li>
				<li class="layui-nav-item">
					<a href="javascript:;">nav groups</a>
					<dl class="layui-nav-child">
						<dd><a href="javascript:;">menu 11</a></dd>
						<dd><a href="javascript:;">menu 22</a></dd>
						<dd><a href="javascript:;">menu 33</a></dd>
					</dl>
				</li>
			</ul>
			<ul class="layui-nav layui-layout-right">
				<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
					<a href="javascript:;">
						<img src="//unpkg.com/outeres@0.0.10/img/layui/icon-v2.png" class="layui-nav-img">
						<?php echo $this->info['name'] ?>
					</a>
					<dl class="layui-nav-child">
						<dd><a href="javascript:;"><?php echo $this->info['name'] ?></a></dd>
						<dd><a href="javascript:;">设置</a></dd>
						<dd><a href="javascript:;">退出</a></dd>
					</dl>
				</li>
				<li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
					<a href="javascript:;">
						<i class="layui-icon layui-icon-more-vertical"></i>
					</a>
				</li>
			</ul>
		</div>
		<div class="layui-side layui-bg-black">
			<div class="layui-side-scroll">
				<!-- 左侧导航区域（可配合layui已有的垂直导航） -->
				<ul class="layui-nav layui-nav-tree" lay-filter="test">
					<li class="layui-nav-item">
						<a href="/admin/index">
							<i class="ri-home-3-line"></i>
							首页
						</a>
					</li>
					<li class="layui-nav-item layui-nav-itemed">
						<a class="" href="javascript:;">
							<i class="ri-article-line"></i>
							内容
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/content/new">新建</a></dd>
							<dd><a href="/admin/content/all">全部</a></dd>
							<dd><a href="/admin/content/type">分类</a></dd>
							<dd><a href="/admin/content/label">标签</a></dd>
							<dd><a href="/admin/content/file">附件</a></dd>

						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;">
							<i class="ri-pages-line"></i>
							页面
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/page/new">新建</a></dd>
							<dd><a href="/admin/page/all">全部</a></dd>
						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="/admin/user/index">
							<i class="ri-user-3-line"></i>
							用户
						</a>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;">
							<i class="ri-apps-2-line"></i>
							资源
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/module/theme">主题</a></dd>
							<dd><a href="/admin/module/plugin">插件</a></dd>
						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;">
							<i class="ri-settings-line"></i>
							设置
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/set/base">基础</a></dd>
							<dd><a href="/admin/set/senior">高级</a></dd>
							<dd><a href="/admin/set/me">个人</a></dd>
							<dd><a href="/admin/set/system">系统</a></dd>
						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="/admin/about/index">
							<i class="ri-information-line"></i>
							关于
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="layui-body">
			<!-- 内容主体区域 -->
			<div style="padding: 15px;">
				<?php
				$url = FrameWork::getAction() . '/' . FrameWork::getData() . '.php';
				if (FrameWork::getAction() == 'index' || null) {
					include_once ADM . 'console.php';
				} else {
					$file = ADM . $url;
					if (!file_exists($file)) {
						$title = 404;
						$error = '页面不存在';
						include_once INC . 'view/error/error.php';
					} else {
						include_once $file;
					}
				}
				?>
			</div>
		</div>
		<div class="layui-footer" style="text-align: right;">
			<!-- 底部固定区域 -->
			Powered by SharkCMS
		</div>
	</div>

	<script>
		//JS 
		layui.use(['element', 'layer', 'util'], function() {
			var element = layui.element;
			var layer = layui.layer;
			var util = layui.util;
			var $ = layui.$;

			//头部事件
			util.event('lay-header-event', {
				menuLeft: function(othis) { // 左侧菜单事件
					layer.msg('展开左侧菜单的操作', {
						icon: 0
					});
				},
				menuRight: function() { // 右侧菜单事件
					layer.open({
						type: 1,
						title: '个性化',
						content: '<div style="padding: 15px;">系统主题</div>',
						area: ['260px', '100%'],
						offset: 'rt', // 右上角
						anim: 'slideLeft', // 从右侧抽屉滑出
						shadeClose: true,
						scrollbar: false
					});
				}
			});
		});
	</script>
</body>

</html>