<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
</head>

<body>
	<form class="layui-form" action="">
		<div class="mainBox">
			<div class="main-container">
				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">
						<input type="text" name="username" lay-verify="required" lay-verify="title" autocomplete="off" placeholder="用户名" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱</label>
					<div class="layui-input-block">
						<input type="email" name="mail" lay-verify="required|email" lay-verify="title" autocomplete="off" placeholder="邮箱" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">密码</label>
					<div class="layui-input-block">
						<input type="password" name="password" lay-verify="required" lay-verify="title" autocomplete="off" placeholder="密码" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">用户组</label>
					<div class="layui-input-block">
						<select name="ugroup" lay-verify="">
							<option value="user">普通用户</option>
							<option value="admin">管理员</option>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">状态</label>
					<div class="layui-input-block">
						<input type="checkbox" name="status" lay-skin="switch" lay-text="封禁|正常" />
					</div>
				</div>
			</div>
		</div>
		<div class="bottom">
			<div class="button-container">
				<button type="submit" class="pear-btn pear-btn-primary pear-btn-sm" lay-submit="" lay-filter="user-save">
					<i class="layui-icon layui-icon-ok"></i>
					提交
				</button>
				<button type="reset" class="pear-btn pear-btn-sm">
					<i class="layui-icon layui-icon-refresh"></i>
					重置
				</button>
			</div>
		</div>
	</form>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script>
		layui.use(['form', 'jquery'], function() {
			let form = layui.form;
			let $ = layui.jquery;

			form.on('submit(user-save)', function(data) {
				$.ajax({
					url: '<?php echo sys_domain(); ?>/index.php/sk-admin/user_add',
					data: JSON.stringify(data.field),
					dataType: 'json',
					contentType: 'application/json',
					type: 'POST',
					success: function(result) {
						if (result.success) {
							layer.msg(result.msg, {
								time: 1000
							}, function() {
								parent.layer.close(parent.layer.getFrameIndex(window
									.name));
								parent.layui.table.reload("user-table");
							});
						} else {
							layer.msg(result.msg, {
								icon: 2,
								time: 1000
							});
						}
					}
				})
				return false;
			});
		})
	</script>
</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	exit;
} else {
	ob_clean();
	$get_json = file_get_contents("php://input");

	// 解析数据
	$key = 'sharkcms';
	$arr = json_decode($get_json, true);
	$name = urlencode($arr['username']);
	$mail = urlencode($arr['mail']);
	$pwd = urlencode(md5_encrypt($arr['password'], $key));
	$ugroup = $arr['ugroup'];
	@$get_status = $arr['status'];
	if ($get_status == null) {
		$status = '0';
		$sql = new sql;
		$sql->sql_config();
		$sql->sql_write('sk_user', 'name,password,mail,ugroup,status', "'$name','$pwd', '$mail', '$ugroup','$status'");
		echo json_encode(array('success' => '200', 'msg' => '添加成功'));

	} elseif ($get_status == 'on') {
		$status = '1';
		$sql = new sql;
		$sql->sql_config();
		$sql->sql_write('sk_user', 'name,password,mail,ugroup,status', "'$name','$pwd', '$mail', '$ugroup','$status'");
		echo json_encode(array('success' => '200', 'msg' => '添加成功'));

	}
}
?>