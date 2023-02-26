<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" rel="stylesheet" />
</head>

<body class="pear-container">
	<div class="layui-card">
		<div class="layui-card-body">
			<table id="role-table" lay-filter="role-table"></table>
		</div>
	</div>

	<script type="text/html" id="role-toolbar">
		<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
			<i class="layui-icon layui-icon-add-1"></i>
			新增
		</button>
		<!-- <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
			<i class="layui-icon layui-icon-delete"></i>
			删除
		</button> -->
	</script>

	<script type="text/html" id="role-bar">
		<!-- <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button> -->
	<button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
	</script>

	<script type="text/html" id="role-enable">
		<input type="checkbox" name="enable" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="role-enable" {{ d.enable== true ? 'checked' : '' }} />
	</script>

	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['table', 'form', 'jquery'], function() {
			let table = layui.table;
			let form = layui.form;
			let $ = layui.jquery;
			key = '<?php get_key() ?>';

			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: 'ID',
						field: 'cid',
						align: 'left',
						width: 10
					},
					{
						title: '标题',
						field: 'title',
						align: 'left',
						width: 200
					},
					{
						title: '简介',
						field: 'introduction',
						align: 'left',
						width: 300
					},
					{
						title: '作者',
						field: 'uid',
						align: 'center'
					},
					{
						title: '权限',
						field: 'order',
						align: 'center'
					},
					{
						title: '时间',
						field: 'created',
						align: 'left',
						width: 170
					},
					{
						title: '操作',
						toolbar: '#role-bar',
						align: 'center',
						width: 195
					}
				]
			]

			table.render({
				elem: '#role-table',
				url: '<?php sys_domain() ?>/index.php/sk-include/api?action=sql_list&table=sk_content&order=asc',
				headers: {
					'Content-Type': 'application/json;charset=utf8',
					'key': key
				},
				page: true,
				cols: cols,
				skin: 'line',
				toolbar: '#role-toolbar',
				defaultToolbar: [{
					title: '刷新',
					layEvent: 'refresh',
					icon: 'layui-icon-refresh',
				}, 'filter']
			});


			table.on('tool(role-table)', function(obj) {
				if (obj.event === 'remove') {
					window.remove(obj);
				} else if (obj.event === 'edit') {
					window.edit(obj);
				} else if (obj.event === 'power') {
					window.power(obj);
				}
			});

			table.on('toolbar(role-table)', function(obj) {
				if (obj.event === 'add') {
					parent.layui.admin.jump(21, "攥写文章", "<?php echo sys_domain(); ?>/index.php/sk-admin/post_edit");
				} else if (obj.event === 'refresh') {
					window.refresh();
				} else if (obj.event === 'batchRemove') {
					window.batchRemove(obj);
				}
			});

			form.on('submit(role-query)', function(data) {
				table.reload('role-table', {
					where: data.field
				})
				return false;
			});

			form.on('switch(role-enable)', function(obj) {
				layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
			});


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
				layer.confirm('确定要删除此文章？', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "<?php sys_domain() ?>/index.php/sk-include/api?action=sql_del&table=sk_content&del=" + obj.data['cid'],
						headers: {
							'Content-Type': 'application/json;charset=utf8',
							'key': key
						},
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
									time: 1000
								});
							}
						}
					})
				});
			}

			window.batchRemove = function(obj) {
				let data = table.checkStatus(obj.config.id).data;
				if (data.length === 0) {
					layer.msg("未选中数据", {
						icon: 3,
						time: 1000
					});
					return false;
				}
				let ids = "";
				for (let i = 0; i < data.length; i++) {
					ids += data[i].cid + ",";
				}
				ids = ids.substr(0, ids.length - 1);
				layer.confirm('确定要删除这些文章？', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "<?php sys_domain() ?>/index.php/sk-include/api?action=sql_del&table=sk_content&del=" + ids,
						headers: {
							'Content-Type': 'application/json;charset=utf8',
							'key': key
						},
						dataType: 'json',
						type: 'delete',
						success: function(result) {
							layer.close(loading);
							if (result.success) {
								layer.msg(result.msg, {
									icon: 1,
									time: 1000
								}, function() {
									table.reload('role-table');
								});
							} else {
								layer.msg(result.msg, {
									time: 1000
								});
							}
						}
					})
				});
			}

			window.refresh = function() {
				table.reload('role-table');
			}
		})
	</script>
</body>

</html>