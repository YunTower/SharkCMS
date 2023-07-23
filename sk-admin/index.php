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
	<link href="https://cdn.bootcdn.net/ajax/libs/normalize/8.0.1/normalize.min.css" rel="stylesheet">
	<link href="/sk-include/static/css/editor.css" rel="stylesheet">
	<script src="/sk-include/static/js/editor.js"></script>
	<script src="/sk-include/static/layui/layui.js"></script>
	<script src="/sk-include/static/js/jquery.min.js"></script>
	<script src="/sk-include/static/js/jquery.pjax.js"></script>
</head>

<body>
	<div class="layui-layout layui-layout-admin">
		<div class="layui-header sk-bg-white">
			<span class="layui-logo layui-hide-xs sk-admin-logo">SharkCMS</span>
			<!-- 头部区域（可配合layui 已有的水平导航） -->
			<ul class="layui-nav layui-layout-left">
				<!-- 移动端显示 -->
				<li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
					<i class="layui-icon layui-icon-spread-left"></i>
				</li>
				<div class="layui-btn-group" id="sk-toolbar-top" style="display:none">
					<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
						<button type="button" class="layui-btn layui-btn-sm layui-btn-danger">删除文章</button>
					</li>
					<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
						<button type="button" class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="save">发表文章</button>
					</li>
				</div>
			</ul>
			<ul class="layui-nav layui-layout-right">
				<!-- 下拉菜单 -->
				<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
					<a href="javascript:;">
						<img src="/api/avatar/<?php echo $this->info['uid'] ?>" class="layui-nav-img" onerror="sk.imgErr()" />
						<?php echo $this->info['name'] ?>
					</a>
				</li>
				<li class="layui-nav-item sk-admin-line-vertical"></li>
				<!-- 登出 -->
				<li class="layui-nav-item sk-admin-login-out" onclick="sk.loginOut()">
					<a>
						<i class="ri-logout-box-r-line"></i>
					</a>
				</li>
			</ul>
		</div>

		<div class="layui-side sk-admin-nav">
			<div class="layui-side-scroll">
				<!-- 左侧导航区域（可配合layui已有的垂直导航） -->
				<ul class="layui-nav layui-nav-tree sk-admin-nav-tree" lay-shrink="all" lay-filter="test">
					<li class="layui-nav-item layui-this">
						<a target!=_blank href="/admin/index">
							<i class="ri-home-3-line"></i>
							首页
						</a>
					</li>
					<li class="layui-nav-item">
						<a class="" href="javascript:;">
							<i class="ri-article-line"></i>
							内容
						</a>
						<dl class="layui-nav-child">
							<dd><a target!=_blank href="/admin/content/new">新建</a></dd>
							<dd><a href="/admin/content/all">全部</a></dd>
							<dd><a href="/admin/content/type">分类</a></dd>
							<dd><a href="/admin/content/label">标签</a></dd>
							<dd><a href="/admin/content/file">附件</a></dd>
						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="/admin/user/index">
							<i class="ri-message-2-line"></i>
							评论
						</a>
					</li>
					<li class="layui-nav-item">
						<a href="/admin/user/index">
							<i class="ri-user-3-line"></i>
							用户
						</a>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;">
							<i class="ri-paint-fill"></i>
							外观
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/theme/page">页面</a></dd>
							<dd><a href="/admin/theme/menu">导航</a></dd>
							<dd><a href="/admin/theme/setting">主题</a></dd>
						</dl>
					</li>
					<li class="layui-nav-item">
						<a href="javascript:;">
							<i class="ri-plug-2-line"></i>
							插件
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/plugin/setting">插件</a></dd>
						</dl>
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
							系统
						</a>
						<dl class="layui-nav-child">
							<dd><a href="/admin/set/base">设置</a></dd>
							<dd><a href="/admin/set/base">资料</a></dd>
							<dd><a href="/admin/set/system">数据</a></dd>
							<dd><a href="/admin/set/update">更新</a></dd>

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
		<div class="layui-body sk-admin-content ">
			<!-- 内容主体区域 -->
			<div class="sk-page-main" id="page" style="padding: 10px;">
				<?php include_once ADM . 'console.php'; ?>
			</div>
		</div>
		<div class="layui-footer">
			<!-- 底部固定区域 -->
			<div class="sk-admin-footer-left" id="sk-toolbar-bottom" style="display:none">
				<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
					<button type="button" class="layui-btn layui-btn-sm layui-btn-danger">删除文章</button>
				</li>
				<li class="layui-nav-item layui-hide layui-show-sm-inline-block">
					<button type="button" class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="save">发表文章</button>
				</li>
			</div>
			<div class="sk-admin-footer-right">
				Powered by <a href="https://www.sharkcms.cn" style="color:var(--main-color-1)">SharkCMS</a>
			</div>
		</div>
	</div>

	<script src="/sk-include/static/js/sharkcms.min.js"></script>
	<script>
		//layui
		layui.use(['element', 'layer', 'util'], function() {
			var element = layui.element;
			var layer = layui.layer;
			var util = layui.util;

		});

		$(document).pjax('a[target!=_blank]', '#page', {
			timeout: 6000
		});
	</script>
</body>

</html>