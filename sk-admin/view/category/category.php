<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>分类</title>
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
							<input type="text" name="id" placeholder="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">分类</label>
						<div class="layui-input-inline">
							<input type="text" name="name" placeholder="" class="layui-input">
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

	<script type="text/html" id="created">
	{{layui.util.toDateString(d.createTime, 'yyyy-MM-dd HH:mm:ss')}}
	</script>
	<script type="text/html" id="bar">
		<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
		<button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
	</script>

	<script src="/sk-admin/component/layui/layui.js"></script>
	<script src="/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['table', 'form', 'jquery', 'common'], function() {
			let table = layui.table;
			let form = layui.form;
			let $ = layui.jquery;
			let common = layui.common;

			document.addEventListener('click', function(event) {
				if (event.srcElement.attributes[2] != null) {
					var nodeName = event.srcElement.attributes[2].nodeName;
					var nodeValue = event.srcElement.attributes[2].nodeValue
					if (nodeName == 'data-url') {
						console.log(nodeValue)
						layer.photos({
							photos: {
								"title": "图片查看器",
								"start": 0,
								"data": [{
										"src": nodeValue,
									},

								]
							}
						});
					}
				}
			})


			let MODULE_PATH = "/api/category/";

			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: 'ID',
						field: 'id',
						align: 'center',
						width: 100
					},
					{
						title: '分类',
						field: 'name',
					},
					{
						title: '作者',
						field: 'uname',
						align: 'center'
					},

					{
						title: '时间',
						field: 'created',
						align: 'center',
						templet: '#created'
					},
					{
						title: '操作',
						toolbar: '#bar',
						align: 'center',
						width: 130,
						fixed: 'right'
					}
				]
			]

			table.render({
				elem: '#table',
				url: '/api/category/get',
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
				layer.open({
					type: 2,
					title: '添加',
					shade: 0.1,
					area: ['350px', '200px'],
					content: '/admin/view?page=view/category/edit.php',
					end: function() {
						table.reloadData('table');
					}
				});
			}

			window.edit = function(obj) {
				layer.open({
					type: 2,
					title: '编辑',
					shade: 0.1,
					area: ['350px', '200px'],
					content: '/admin/view?page=view/category/edit.php&action=edit&id=' + obj.data['id'],
					end: function() {
						table.reloadData('table');
					}
				});
			}

			window.remove = function(obj) {
				layer.confirm('确定要删除该分类', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "/api/category/remove?id=" + obj.data['id'],
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
				var checkIds = common.checkField(obj, 'id');
				if (checkIds === "") {
					layer.msg("未选中数据", {
						icon: 3,
						time: 1000
					});
					return false;
				}

				layer.confirm('确定要删除这些分类', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "/api/category/batchRemove?id=" + checkIds,
						dataType: 'json',
						type: 'delete',
						success: function(result) {
							layer.close(loading);
							if (result.success) {
								layer.msg(result.msg, {
									icon: 1,
									time: 1000
								}, function() {
									table.reloadData('table');
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