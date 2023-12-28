<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>用户</title>
	<link rel="stylesheet" href="/sk-admin/component/pear/css/pear.css" />
</head>

<body class="pear-container">
	<div class="layui-card">
		<div class="layui-card-body">
			<form class="layui-form" action="">
				<div class="layui-form-item">
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">UID</label>
						<div class="layui-input-inline">
							<input type="number" name="uid" placeholder="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">用户名</label>
						<div class="layui-input-inline">
							<input type="text" name="name" placeholder="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">邮箱</label>
						<div class="layui-input-inline">
							<input type="email" name="mail" placeholder="" class="layui-input">
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
	<script>
		function formatTime(timestamp) {
			var time = timestamp
			var date = new Date(time * 1000);
			var year = date.getFullYear();
			var month = date.getMonth() + 1;
			var day = date.getDate();
			var hour = date.getHours();
			var minute = date.getMinutes();
			var second = date.getSeconds();
			return year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
		}
	</script>
	<script type="text/html" id="toolbar">
		<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
			<i class="layui-icon layui-icon-add-1"></i>
			新增
		</button>
		<button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
			<i class="layui-icon layui-icon-delete"></i>
			删除
		</button>
	</script>

	<script type="text/html" id="avatar">
	{{#if (d.avatar == null) { }}
		<span>无</span>
		{{# }else { }}
			<span style="color:#0969da" id="ImagePreview" data-url="{{ d.avatar }}">查看</span>
			{{# } }}
	</script>
	<script type="text/html" id="ban">
	{{#if (d.ban == 0 || d.ban== '' || d.ban == null) { }}
		<span style="color: green">正常</span>
		{{# }else if(d.ban == 1){ }}
			<span style="color: red">封禁</span>
			{{# } }}
	</script>
	<script type="text/html" id="logintime">
	{{#if (d.logintime == 0 || d.logintime== '' || d.logintime == null) { }}
		<span>未登录</span>
		{{# }else{ }}
			<span>{{= formatTime(d.logintime) }}</span>
			{{# } }}
	</script>
	<script type="text/html" id="created">
		<span>{{= formatTime(d.created) }}</span>
	</script>
	<script type="text/html" id="bar">
		<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
		<button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
	</script>

	<script src="/sk-admin/component/layui/layui.js"></script>
	<script src="/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['table', 'form', 'jquery', 'common', 'layer'], function() {
			let table = layui.table,
				form = layui.form,
				$ = layui.jquery,
				common = layui.common,
				layer = layui.layer;

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

			let MODULE_PATH = "/api/user/";

			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: 'UID',
						field: 'uid',
						width: 50,
					},
					{
						title: '用户名',
						field: 'name',
						width: 180,

					},
					{
						title: '邮箱',
						field: 'mail',
						width: 200
					},
					{
						title: '头像',
						field: 'avatar',
						templet: '#avatar',
						width: 80
					},
					{
						title: '状态',
						field: 'ban',
						width: 100,
						templet: '#ban'
					},
					{
						title: '角色',
						field: 'role',
						width: 100,
						templet: '#role'
					},
					{
						title: 'UA',
						field: 'ua',
						width: 150
					},
					{
						title: '登录时间',
						field: 'logintime',
						width: 150,
						templet: '#logintime'
					},
					{
						title: '创建时间',
						field: 'created',
						width: 150,
						templet: '#created'
					},
					{
						title: '操作',
						toolbar: '#bar',
						width: 130,
						fixed: 'right'
					}
				]
			]

			table.render({
				elem: '#table',
				url: '/api/user/get',
				page: true,
				cols: cols,
				skin: 'line',
				toolbar: '#toolbar',
				defaultToolbar: [{
					title: '刷新',
					layEvent: 'refresh',
					icon: 'layui-icon-refresh',
				}, 'filter', 'exports']
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
				table.reloadData('table', {
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
					area: ['350px', '500px'],
					content: '/admin/view?page=view/user/add.php',
					end: function() {
						table.reloadData('table');
					}
				});
			}

			window.edit = function(obj) {
				layer.open({
					type: 2,
					title: '修改 - ' + obj.data.uid + ' - ' + obj.data.name,
					shade: 0.1,
					area: ['350px', '500px'],
					content: '/admin/view?page=view/user/edit.php&uid=' + obj.data.uid,
					end: function() {
						table.reloadData('table');
					}
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
						url: MODULE_PATH + "remove?uid=" + obj.data['uid'],
						dataType: 'json',
						type: 'delete',
						success: function(result) {
							layer.close(loading);
							if (result.code == 200) {
								layer.msg(result.msg, {
									icon: 1,
									time: 1000
								}, function() {
									obj.del();
								});
							} else {
								layer.alert(result.msg, {
									icon: 2,
								});
							}
						}
					})
				});
			}

			window.batchRemove = function(obj) {
				var checkIds = common.checkField(obj, 'uid');
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
						url: MODULE_PATH + "batchRemove?uid=" + checkIds,
						dataType: 'json',
						type: 'post',
						success: function(result) {
							layer.close(loading);
							if (result.code == 200) {
								layer.msg(result.msg, {
									icon: 1,
									time: 1000
								}, function() {
									table.reload('table');
								});
							} else {
								layer.alert(result.msg, {
									icon: 2,
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