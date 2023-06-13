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
						官方公告
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
					</tr>
					<tr>
						<td>系统版本</td>
					</tr>
					<tr>
						<td>版本类型</td>
						<td>
						</td>
					</tr>

					<tr>
						<td>PHP版本</td>
						<td><?php echo PHP_VERSION ?></td>
					</tr>
					<tr>
						<td>解释引擎</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- <div class="layui-card">
				<div class="layui-card-header">系统公告</div>
				<div class="layui-card-body">
					<ul class="list">
						<li class="list-item">
							<span class="title">SharkCMS 1.0.0内测版上线</span>
							<span class="footer">2023-02-01</span>
						</li>
					</ul>
				</div>
			</div> -->
	</div>
</div>