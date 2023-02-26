<?php admin_power() ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>控制台</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/console.css" />
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
										<div class="count pear-text">
											<p id="post"></p>
										</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">用户总数</div>
										<div class="count pear-text">
											<p id="user"></p>
										</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">菜单总数</div>
										<div class="count pear-text">
											<p id="menu"></p>
										</div>
									</div>
								</div>
								<div class="layui-col-md6 layui-col-sm6 layui-col-xs6">
									<div class="pear-card2">
										<div class="title">页面总数</div>
										<div class="count pear-text">
											<p id="page"></p>
										</div>
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
							<table id="role-table"></table>
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
								<?php sys_en_t() ?>
							</td>
						</tr>

						<tr>
							<td>PHP版本</td>
							<td><?php echo PHP_VERSION ?></td>
						</tr>
						<tr>
							<td>解释引擎</td>
							<td><?php sys_en_engine() ?></td>
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
					var count = JSON.parse(obj.count);
					console.log(count);
					$("#post").html(count.post);
					$("#menu").html(count.menu);
					$("#user").html(count.user);
					$("#page").html(count.page);

					domain = obj.domain
				}
			})

			// 版本更新检查
			sys_check()

			function sys_check() {
				$.ajax({
					url: "https://api.sharkcms.cn/update/<?php echo App_T ?>/check.php?v=<?php echo App_V ?>&d=<?php echo sys_domain() ?>&t=<?php echo time() ?>",
					type: "GET",
					async: false,
					dataType: "jsonp",
					jsonp: "callback",
					success: function(data) {
						if (data.install != 'no') {
							layer.msg(data.msg)
						}
					}
				})
			}

			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: 'ID',
						field: 'cid',
						align: 'center',
						width: 10
					},
					{
						title: '标题',
						field: 'title',
						align: 'center',
						width: 150
					},
					{
						title: '简介',
						field: 'introduction',
						align: 'center',
					},
					{
						title: '作者',
						field: 'uid',
						align: 'center'
					},
					{
						title: '时间',
						field: 'created',
						align: 'center',
						width: 160
					}
				]
			]

			table.render({
				elem: '#role-table',
				url: domain + '/index.php/sk-include/api?action=sql_list&table=sk_content&page=1&limit=4&order=desc',
				async: false,
				headers: {
					'Content-Type': 'application/json;charset=utf8',
					'key': key
				},
				cols: cols,
				skin: 'line'
			});

		});
	</script>
</body>

</html>