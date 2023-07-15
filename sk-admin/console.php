<div class="layui-row layui-col-space10 sk-home">
	<div class="layui-row layui-col-space6 sk-card-home">
		<!-- 文章统计 -->
		<div class="layui-col-xs6 layui-col-md3 sk-card-post">
			<div class="layui-card">
				<div class="layui-card-header" id="title">
					文章数量
				</div>
				<div class="layui-card-body" id="count">
					4
				</div>
			</div>
		</div>

		<div class="layui-col-xs6 layui-col-md3 sk-card-user">
			<div class="layui-card">
				<div class="layui-card-header" id="title">
					用户数量
				</div>
				<div class="layui-card-body" id="count">
					3
				</div>
			</div>
		</div>

		<div class="layui-col-xs6 layui-col-md3 sk-card-menu">
			<div class="layui-card">
				<div class="layui-card-header" id="title">
					菜单数量
				</div>
				<div class="layui-card-body" id="count">
					3
				</div>
			</div>
		</div>

		<div class="layui-col-xs6 layui-col-md3 sk-card-page">
			<div class="layui-card">
				<div class="layui-card-header" id="title">
					页面数量
				</div>
				<div class="layui-card-body" id="count">
					1
				</div>
			</div>
		</div>
	</div>

	<div class="layui-col-md8">
		<div class="layui-row layui-col-space3">
			<div class="layui-card">
				<div class="layui-card-header">
					官方公告
				</div>
				<div class="layui-card-body">
					<table class="layui-table">
						<thead>
							<tr>
								<th>ID</th>
								<th>标题</th>
								<th>摘要</th>
								<th>分类</th>
								<th>发布时间</th>
							</tr>
							<?php
							foreach (Cloud::getNews() as $n) {
								print <<<EOT
								<td>$n[id]</td>
								<td><a class="sk-url" target="_blank" href="https://www.sharkcms.cn/index/news/$n[id]">$n[title]</a></td>
								<td>$n[slug]</td>
								<td><a class="sk-url" target="_blank" href="https://www.sharkcms.cn/index/news/$n[category]">$n[category]</a></td>
								<td>$n[created]</td>
								EOT;
							}
							?>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="layui-col-md4">
		<div class="layui-card layui-col-space3">
			<div class="layui-card-header">系统信息</div>
			<div class="layui-card-body">
				<table class="layui-table">
					<tr>
						<td>系统名称</td>
						<td>SharkCMS</td>
					</tr>
					<tr>
						<td>系统版本</td>
						<td>v1.0.0-dev.11</td>
					</tr>
					<tr>
						<td>版本类型</td>
						<td>开发版</td>
					</tr>

					<tr>
						<td>PHP版本</td>
						<td><?php echo PHP_VERSION ?></td>
					</tr>
					<tr>
						<td>解释引擎</td>
						<td>Nginx</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>