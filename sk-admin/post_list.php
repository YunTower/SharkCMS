
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>用户管理</title>
		<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	</head>
	<body class="pear-container">
		
		<div class="layui-card">
			<div class="layui-card-body">
				<table id="user-table" lay-filter="user-table"></table>
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
			<input type="checkbox" name="enable" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="user-enable" {{ d.enable== true ? 'checked' : '' }} />
		</script>

		<script type="text/html" id="user-sex">
			{{#if (d.sex == 1) { }}
		    <span>男</span>
		    {{# }else if(d.sex == 2){ }}
		    <span>女</span>
		    {{# } }}
		</script>

		<script type="text/html" id="user-login">
			{{#if (d.login == 0) { }}
		    <span>在线</span>
		    {{# }else if(d.sex == 1){ }}
		    <span>离线</span>
		    {{# } }}
		</script>

		<script type="text/html" id="user-createTime">
			{{layui.util.toDateString(d.createTime, 'yyyy-MM-dd')}}
		</script>

		<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
		<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
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
							title: '账号',
							field: 'username',
							align: 'center',
							width: 100
						},
						{
							title: '姓名',
							field: 'realName',
							align: 'center'
						},
						{
							title: '性别',
							field: 'sex',
							align: 'center',
							width: 80,
							templet: '#user-sex'
						},
						{
							title: '电话',
							field: 'phone',
							align: 'center'
						},
						{
							title: '启用',
							field: 'enable',
							align: 'center',
							templet: '#user-enable'
						},
						{
							title: '登录',
							field: 'login',
							align: 'center',
							templet: '#user-login'
						},
						{
							title: '注册',
							field: 'createTime',
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
					elem: '#user-table',
					url: '<?php echo sys_domain(); ?>/sk-admin/admin/data/user.json',
					page: true,
					cols: cols,
					skin: 'line',
					toolbar: '#user-toolbar',
					defaultToolbar: [{
						title: '刷新',
						layEvent: 'refresh',
						icon: 'layui-icon-refresh',
					}, 'filter']
				});

				table.on('tool(user-table)', function(obj) {
					if (obj.event === 'remove') {
						window.remove(obj);
					} else if (obj.event === 'edit') {
						window.edit(obj);
					}
				});

				table.on('toolbar(user-table)', function(obj) {
					if (obj.event === 'add') {
						window.add();
					} else if (obj.event === 'refresh') {
						window.refresh();
					} else if (obj.event === 'batchRemove') {
						window.batchRemove(obj);
					}
				});

				form.on('submit(user-query)', function(data) {
					table.reload('user-table', {
						where: data.field
					})
					return false;
				});

				form.on('switch(user-enable)', function(obj) {
					layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
				});

				window.add = function() {
					parent.layui.admin.jump(21,"攥写文章","<?php echo sys_domain();?>/index.php/sk-admin/post_edit")
				
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
										table.reload('user-table');
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
					table.reload('user-table');
				}
			})
		</script>
	</body>
</html>
