<div class="layui-row layui-col-space10 sk-home">
	<div class="layui-row layui-col-space6 sk-card-home">
		<!-- 文章统计 -->
		<div class="layui-col-xs6 layui-col-md3 sk-card-post">
			<div class="layui-card">
				<div class="layui-card-header" id="title">
					文章数量
				</div>
				<div class="layui-card-body" id="count">

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
					<table class="layui-hide" id="table-news"></table>
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
						<td>云端状态</td>
						<td>连接正常</td>
					</tr>
					<tr>
						<td>PHP版本</td>
						<td>22</td>
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
<script>
	$.ajax({
		url: origin + ''
	})

	layui.use('table', function() {
		var table = layui.table;
		// 创建渲染实例
		table.render({
			elem: '#table-news',
			url: '/api/getNews',
			parseData:function(res){
				if (res.code !== 0){
					layer.alert(res.msg,{title:'系统错误',icon:2})
				}
			},
			cols: [
				[{
						field: 'id',
						width: 50,
						title: 'ID',
						sort: true
					},
					{
						field: 'title',
						width: 200,
						title: '标题'
					},
					{
						field: 'slug',
						title: '摘要'
					},
					{
						field: 'category',
						width: 100,
						title: '分类'
					},
					{
						field: 'uname',
						width: 100,
						title: '作者'
					},
					{
						field: 'created',
						width: 180,
						title: '时间',
						sort: true
					}
				]
			],
		});

	});
</script>