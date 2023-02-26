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
		<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
		<button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
	</script>

	<script type="text/html" id="role-enable">
		<input type="checkbox" name="enable" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="role-enable" {{ d.enable== true ? 'checked' : '' }} />
	</script>

	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['table', 'form', 'jquery'], function() {
			let table = layui.table,
				form = layui.form,
				$ = layui.jquery,
				common = layui.common,
				key = '<?php get_key() ?>';
				
				cols = [
					[{
							type: 'checkbox'
						},
						{
							title: 'ID',
							field: 'uid',
							align: 'left',
							width: 100
						},
						{
							title: '用户名',
							field: 'name',
							align: 'left',
							width: 100
						},
						{
							title: '邮箱',
							field: 'mail',
							align: 'center'
						},
						{
							title: '用户组',
							field: 'ugroup',
							align: 'center'
						},
						{
							title: '注册时间',
							field: 'created',
							align: 'center'
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
				url: '<?php sys_domain() ?>/index.php/sk-include/api?action=sql_list&table=sk_user&order=asc',
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
					window.add();
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

			window.add = function() {
				layer.open({
					type: 2,
					title: '新增',
					shade: 0.1,
					area: ['500px', '400px'],
					content: '<?php sys_domain() ?>/index.php/sk-admin/user_add'
				});
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
				layer.confirm('确定要删除此用户？', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "<?php sys_domain() ?>/index.php/sk-include/api?action=sql_del&table=sk_user&del=" + obj.data['uid'],
						headers: {
							'Content-Type': 'application/json;charset=utf8',
							'key': key
						},
						dataType: 'json',
						type: 'POST',
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
					ids += data[i].uid + ",";
				}
				ids = ids.substr(0, ids.length - 1);
				layer.confirm('确定要删除这些用户？', {
					icon: 3,
					title: '提示'
				}, function(index) {
					layer.close(index);
					let loading = layer.load();
					$.ajax({
						url: "<?php sys_domain() ?>/index.php/sk-include/api?action=sql_del&table=sk_user&del=" + ids,
						headers: {
							'Content-Type': 'application/json;charset=utf8',
							'key': key
						},
						dataType: 'json',
						type: 'POST',
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