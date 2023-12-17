<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>文章</title>
		<link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
	</head>
	<body class="pear-container">
		<div class="layui-card">
			<div class="layui-card-body">
				<form class="layui-form" action="">
					<div class="layui-form-item">
						<div class="layui-form-item layui-inline">
							<label class="layui-form-label">ID</label>
							<div class="layui-input-inline">
								<input type="text" name="realName" placeholder="" class="layui-input">
							</div>
						</div>
						<div class="layui-form-item layui-inline">
							<label class="layui-form-label">标题</label>
							<div class="layui-input-inline">
								<input type="text" name="realName" placeholder="" class="layui-input">
							</div>
						</div>

						<div class="layui-form-item layui-inline">
							<button class="pear-btn pear-btn-md pear-btn-primary" lay-submit lay-filter="user-query">
								<i class="layui-icon layui-icon-search"></i>
								查询
							</button>
							<button type="reset" class="pear-btn pear-btn-md">
								<i class="layui-icon layui-icon-refresh"></i>
								重置
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="layui-card">
			<div class="layui-card-body">
				<table id="table" lay-filter="table"></table>
			</div>
		</div>

		<script type="text/html" id="user-toolbar">
			<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
		        <i class="layui-icon layui-icon-add-1"></i>
		        新增
		    </button>
		    <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
		        <i class="layui-icon layui-icon-delete"></i>
		        删除
		    </button>
		</script>

		<script type="text/html" id="user-bar">
			<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
		    <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
		</script>

		<script type="text/html" id="user-enable">
			<input type="checkbox" name="enable" value="{{d.id}}" lay-skin="switch" lay-text="公开|私密" lay-filter="user-enable" {{ d.enable== true ? 'checked' : '' }} />
		</script>

		<script type="text/html" id="user-sex">
			{{#if (d.sex == 1) { }}
		    <span>男</span>
		    {{# }else if(d.sex == 2){ }}
		    <span>女</span>
		    {{# } }}
		</script>

		<script type="text/html" id="author">
			{{#if (d.login == 0) { }}
		    <span>在线</span>
		    {{# }else if(d.sex == 1){ }}
		    <span>离线</span>
		    {{# } }}
		</script>

		<script type="text/html" id="user-createTime">
			{{layui.util.toDateString(d.createTime, 'yyyy-MM-dd')}}
		</script>

		<script src="/sk-admin/component/layui/layui.js"></script>
		<script src="/sk-admin/component/pear/pear.js"></script>
		<script>
			layui.use(['table', 'form', 'jquery','common'], function() {
				let table = layui.table;
				let form = layui.form;
				let $ = layui.jquery;
				let common = layui.common;

				let MODULE_PATH = "operate/";

				let cols = [
					[{
							type: 'checkbox'
						},
						{
							title: 'ID',
							field: 'cid',
							align: 'center',
							width: 100
						},
						{
							title: '标题',
							field: 'title',
							align: 'center'
						},
						{
							title: '分类',
							field: 'category',
							align: 'center',
							width: 80,
							templet: '#user-sex'
						},
						{
							title: '标签',
							field: 'tag',
							align: 'center'
						},
						{
							title: '状态',
							field: 'status',
							align: 'center',
							templet: '#user-enable'
						},
						{
							title: '作者',
							field: 'uid',
							align: 'center',
							templet: '#user-login'
						},
						{
							title: '评论',
							field: 'allowComment',
							align: 'center',
							templet: '#author'
						},
						{
							title: '时间',
							field: 'created',
							align: 'center',
							templet: '#user-createTime'
						},
						{
							title: '操作',
							toolbar: '#user-bar',
							align: 'center',
							width: 130
						}
					]
				]

				table.render({
					elem: '#table',
					url: '/api/article/get',
					page: true,
					cols: cols,
					skin: 'line',
					toolbar: '#user-toolbar',
					defaultToolbar: [{
						title: '刷新',
						layEvent: 'refresh',
						icon: 'layui-icon-refresh',
					}, 'filter', 'print', 'exports']
				});

				table.on('tool(table)', function(obj) {
					if (obj.event === 'remove') {
						window.remove(obj);
					} else if (obj.event === 'edit') {
						window.edit(obj);
					}
				});

				table.on('toolbar(table)', function(obj) {
					if (obj.event === 'add') {
						window.add();
					} else if (obj.event === 'refresh') {
						window.refresh();
					} else if (obj.event === 'batchRemove') {
						window.batchRemove(obj);
					}
				});

				form.on('submit(user-query)', function(data) {
					table.reload('table', {
						where: data.field
					})
					return false;
				});

				form.on('switch(user-enable)', function(obj) {
					layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
				});

				window.add = function() {
					parent.layui.admin.addTab(0,"撰写文章","/admin/view?page=view/content/editor.php")
				}

				window.edit = function(obj) {
					layer.open({
						type: 2,
						title: '修改',
						shade: 0.1,
						area: ['500px', '400px'],
						content: MODULE_PATH + 'edit.html'
					});
				}

				window.remove = function(obj) {
					layer.confirm('确定要删除该用户', {
						icon: 3,
						title: '提示'
					}, function(index) {
						layer.close(index);
						let loading = layer.load();
						$.ajax({
							url: MODULE_PATH + "remove/" + obj.data['userId'],
							dataType: 'json',
							type: 'delete',
							success: function(result) {
								layer.close(loading);
								if (result.success) {
									layer.msg(result.msg, {
										icon: 1,
										time: 1000
									}, function() {
										obj.del();
									});
								} else {
									layer.msg(result.msg, {
										icon: 2,
										time: 1000
									});
								}
							}
						})
					});
				}

				window.batchRemove = function(obj) {
					
					var checkIds = common.checkField(obj,'userId');
					
					if (checkIds === "") {
						layer.msg("未选中数据", {
							icon: 3,
							time: 1000
						});
						return false;
					}
					
					layer.confirm('确定要删除这些用户', {
						icon: 3,
						title: '提示'
					}, function(index) {
						layer.close(index);
						let loading = layer.load();
						$.ajax({
							url: MODULE_PATH + "batchRemove/" + ids,
							dataType: 'json',
							type: 'delete',
							success: function(result) {
								layer.close(loading);
								if (result.success) {
									layer.msg(result.msg, {
										icon: 1,
										time: 1000
									}, function() {
										table.reload('table');
									});
								} else {
									layer.msg(result.msg, {
										icon: 2,
										time: 1000
									});
								}
							}
						})
					});
				}

				window.refresh = function(param) {
					table.reload('table');
				}
			})
		</script>
	</body>
</html>
