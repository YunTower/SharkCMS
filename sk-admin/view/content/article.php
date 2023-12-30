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
						<label class="layui-form-label">CID</label>
						<div class="layui-input-inline">
							<input type="text" name="cid" placeholder="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">标题</label>
						<div class="layui-input-inline">
							<input type="text" name="title" placeholder="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item layui-inline">
						<label class="layui-form-label">摘要</label>
						<div class="layui-input-inline">
							<input type="text" name="slug" placeholder="" class="layui-input">
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


	<script type="text/html" id="cover">
	{{#if (d.cover == '' || d.cover==null) { }}
		<span>无</span>
		{{# }else { }}
			<span style="color:#0969da" id="ImagePreview" data-url="{{ d.avatar }}">查看</span>
			{{# } }}
	</script>
	<script type="text/html" id="category">
	{{#if (d.category == '' || d.category==null) { }}
		<span class="layui-badge-rim">无</span>
		{{# }else { }}
			<span class="layui-badge layui-bg-blue">{{d.category}}</span>
			{{# } }}
	</script>
	<script type="text/html" id="tag">
	{{#if (d.tag == '' || d.tag==null) { }}
		<span class="layui-badge-rim">无</span>
		{{# }else { }}
			{{#if (Array.from(JSON.parse(d.tag)).length>1) { }}
				{{# layui.each(d.tag, function(index, item){ }}
					<span class="layui-badge-rim">{{= item }}</span>
					{{# }); }}
						{{# }else { }}
							<span class="layui-badge-rim">{{ d.tag }}</span>
							{{# } }}
	</script>
	<script type="text/html" id="status">
	{{#if (d.status == 0 || d.status==null) { }}
		<span style="color:red">私密</span>
		{{# }else if (d.status==1) { }}
			<span style="color:#0969da">公开</span>
			{{# } }}
	</script>
	<script type="text/html" id="top">
	{{#if (d.top == 0 || d.top==null) { }}
		<span style="color:red">否</span>
		{{# }else if (d.top==1) { }}
			<span style="color:#0969da">是</span>
			{{# } }}
	</script>
	<script type="text/html" id="created">
	{{layui.util.toDateString(d.createTime, 'yyyy-MM-dd HH:mm:ss')}}
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


			let MODULE_PATH = "operate/";

			let cols = [
				[{
						type: 'checkbox'
					},
					{
						title: 'CID',
						field: 'cid',
						align: 'center',
						width: 100
					},
					{
						title: '标题',
						field: 'title',
					},
					{
						title: '摘要',
						field: 'slug',
					},
					{
						title: '封面',
						field: 'title',
						align: 'cover',
						templet: '#cover'
					},
					{
						title: '分类',
						field: 'category',
						align: 'center',
						templet: '#category'
					},
					{
						title: '标签',
						field: 'tag',
						align: 'center',
						templet: '#tag'
					},
					{
						title: '状态',
						field: 'status',
						align: 'center',
						templet: '#status'
					},
					{
						title: '作者',
						field: 'uname',
						align: 'center'
					},
					{
						title: '评论',
						field: 'allowComment',
						align: 'center',
						templet: '#author'
					},
					{
						title: '置顶',
						field: 'top',
						align: 'center',
						templet: '#top'
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
				parent.layui.admin.addTab(0, "撰写文章", "/admin/view?page=view/content/editor.php")
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

				var checkIds = common.checkField(obj, 'userId');

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