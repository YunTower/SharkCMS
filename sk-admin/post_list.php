<?php
if (!defined('App_N')) {
    Header('Location: ../../index.php/sk-admin/login');
} else {
    // 权限验证
    if (!isset($_COOKIE["login_status"])) {
        Header('Location: ../../index.php/sk-admin/login');
    } else {
        // 解析token
        $json = base64_decode(md5_decrypt(($_COOKIE['user_token']), 'sharkcms-user-token'));
        $arr = json_decode($json, true);
        // 如果用户组不是admin
        if ($arr['group'] != 'admin') {
            Header('Location: ../../index.php/sk-admin/login');
        } else {
            // 如果超时
            if ($arr['login_out'] - $arr['login_time'] > 60 * 60 * 24 * 30) {
                // 删除token&cookie
                unset($_SESSION['login_token']);
                setcookie("login_token", "", time() - 3600);
                Header('Location: ../../index.php/sk-admin/login');
            }
        }
    }
} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>角色管理</title>
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
			<button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
				<i class="layui-icon layui-icon-delete"></i>
				删除
			</button>
		</script>
		
		<script type="text/html" id="role-bar">
			<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
			<button class="pear-btn pear-btn-warming pear-btn-sm" lay-event="power"><i class="layui-icon layui-icon-vercode"></i></button>
			<button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
		</script>
		
		<script type="text/html" id="role-enable">
			<input type="checkbox" name="enable" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="role-enable"  {{ d.enable== true ? 'checked' : '' }} />
		</script>

		<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
		<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
		<script>
		    layui.use(['table','form','jquery'],function () {
		        let table = layui.table;
		        let form = layui.form;
		        let $ = layui.jquery;
		
		        let MODULE_PATH = "operate/";
		
		        let cols = [
		            [
		                {type:'checkbox'},
		                {title: '角色名', field: 'roleName', align:'center', width:100},
		                {title: 'Key值', field: 'roleCode', align:'center'},
		                {title: '描述', field: 'details', align:'center'},
		                {title: '是否可用', field: 'enable', align:'center', templet:'#role-enable'},
		                {title: '操作', toolbar: '#role-bar', align:'center', width:195}
		            ]
		        ]
		
		        table.render({
		            elem: '#role-table',
		            url: '../../admin/data/role.json',
		            page: true ,
		            cols: cols ,
		            skin: 'line',
		            toolbar: '#role-toolbar',
		            defaultToolbar: [{
						title: '刷新',
		                layEvent: 'refresh',
		                icon: 'layui-icon-refresh',
		            }, 'filter', 'print', 'exports']
		        });
		
		        table.on('tool(role-table)', function(obj){
		            if(obj.event === 'remove'){
		                window.remove(obj);
		            } else if(obj.event === 'edit'){
		                window.edit(obj);
		            } else if(obj.event === 'power'){
		                window.power(obj);
		            }
		        });
		
		        table.on('toolbar(role-table)', function(obj){
		            if(obj.event === 'add'){
		                window.add();
		            } else if(obj.event === 'refresh'){
		                window.refresh();
		            } else if(obj.event === 'batchRemove'){
		                window.batchRemove(obj);
		            }
		        });
		
		        form.on('submit(role-query)', function(data){
		            table.reload('role-table',{where:data.field})
		            return false;
		        });
		
		        form.on('switch(role-enable)', function(obj){
		            layer.tips(this.value + ' ' + this.name + '：'+ obj.elem.checked, obj.othis);
		        });
		
		        window.add = function(){
		            layer.open({
		                type: 2,
		                title: '新增',
		                shade: 0.1,
		                area: ['500px', '400px'],
		                content: MODULE_PATH + 'add.html'
		            });
		        }
		
		        window.power = function(obj){
		            layer.open({
		                type: 2,
		                title: '授权',
		                shade: 0.1,
		                area: ['320px', '400px'],
		                content: MODULE_PATH + 'edit.html'
		            });
		        }
		
		        window.edit = function(obj){
		            layer.open({
		                type: 2,
		                title: '修改',
		                shade: 0.1,
		                area: ['500px', '400px'],
		                content: MODULE_PATH + 'edit.html'
		            });
		        }
		
		        window.remove = function(obj){
		            layer.confirm('确定要删除该角色', {icon: 3, title:'提示'}, function(index){
		                layer.close(index);
		                let loading = layer.load();
		                $.ajax({
		                    url: MODULE_PATH+"remove/"+obj.data['roleId'],
		                    dataType:'json',
		                    type:'delete',
		                    success:function(result){
		                        layer.close(loading);
		                        if(result.success){
		                            layer.msg(result.msg,{icon:1,time:1000},function(){
		                                obj.del();
		                            });
		                        }else{
		                            layer.msg(result.msg,{icon:2,time:1000});
		                        }
		                    }
		                })
		            });
		        }
		
		        window.batchRemove = function(obj){
		            let data = table.checkStatus(obj.config.id).data;
		            if(data.length === 0){
		                layer.msg("未选中数据",{icon:3,time:1000});
		                return false;
		            }
		            let ids = "";
		            for(let i = 0;i<data.length;i++){
		                ids += data[i].roleId+",";
		            }
		            ids = ids.substr(0,ids.length-1);
		            layer.confirm('确定要删除这些用户', {icon: 3, title:'提示'}, function(index){
		                layer.close(index);
		                let loading = layer.load();
		                $.ajax({
		                    url: MODULE_PATH+"batchRemove/"+ids,
		                    dataType:'json',
		                    type:'delete',
		                    success:function(result){
		                        layer.close(loading);
		                        if(result.success){
		                            layer.msg(result.msg,{icon:1,time:1000},function(){
		                                table.reload('role-table');
		                            });
		                        }else{
		                            layer.msg(result.msg,{icon:2,time:1000});
		                        }
		                    }
		                })
		            });
		        }
		
		        window.refresh = function(){
		            table.reload('role-table');
		        }
		    })
		</script>
	</body>
</html>
