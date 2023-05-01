<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>登陆账号 - SharkCMS</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="<?php echo $this->Domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo $this->Domain(); ?>/sk-admin/admin/css/other/login.css" />
</head>
<!-- 代 码 结 构 -->

<body style="background-size: cover;">
	<form class="layui-form layui-panel" style="padding: 10px 15px;" action="javascript:void(0);">
		<div class="layui-form-item">
			<img class="logo" />
			<div class="title">SharkCMS</div>
			<div class="desc">
				登 陆 账 号
			</div>
		</div>
		<div class="layui-form-item">
			<input type="email" placeholder="账号（邮箱）" value="286267038@qq.com" id="mail" lay-verify="required|email" hover class="layui-input" />
		</div>
		<div class="layui-form-item">
			<input type="password" placeholder="密码" value="testtest" id="pwd" lay-verify="required" hover class="layui-input" />
		</div>
		<!-- <div class="layui-form-item">
				<input placeholder="验证码 : "  hover  lay-verify="required" class="code layui-input layui-input-inline"  />
				<img src="<?php echo $this->Domain(); ?>/sk-admin/admin/images/captcha.gif" class="codeImage" />
			</div> -->
		<div class="layui-form-item">
			<input type="checkbox" name="" title="记住密码" lay-skin="primary" checked>
		</div>
		<div class="layui-form-item">
			<button type="button" class="pear-btn pear-btn-success login" lay-submit lay-filter="login">
				登 陆
			</button>
		</div>
	</form>
	<!-- 资 源 引 入 -->
	<script src="<?php echo $this->Domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo $this->Domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script src="<?php echo $this->Domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
	<script src="<?php echo $this->Domain(); ?>/sk-include/static/js/sharkcms.base64.js"></script>
	<script>
		layui.use(['form', 'button', 'popup'], function() {
			var form = layui.form;
			var button = layui.button;
			var popup = layui.popup;

			form.on('submit(login)', function() {
				var mail = Base64.encode($('#mail').val())
				var pwd = Base64.encode($('#pwd').val());
				var time = Math.floor(Date.now() / 1000);
				layer.msg('正在登陆')
				var data = JSON.stringify({
					mail: mail,
					pwd: pwd,
					time: time
				});

				button.load({
					elem: '.login',
					time: 50,
					done: function() {
						$.ajax({
							type: "POST",
							url: "../../index.php/sk-admin/login",
							dataType: "json",
							data: data,
							contentType: "application/jsoan",
							success: function(data) {
								var obj = JSON.parse(JSON.stringify(data));
								console.log(obj);
								if (obj.code == 'error') {
									layer.alert(obj.error)
								} else if (obj.code == '200') {
									popup.success("登录成功", function() {
										location.href = '../../index.php/sk-admin/index'
									})
								} else {
									layer.alert('系统错误！')
								}
							}
						});
					}
				})
			});
		})
	</script>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	exit;
} else {
	// 清空缓冲区
	ob_clean();
	// 接收数据
	$POST = file_get_contents("php://input");
	$arr = json_decode($POST, true);
	$mail = $arr['mail'];
	$pwd = $arr['pwd'];
	$time = $arr['time'];

	// 判断请求是否超时
	if ($time > time() - 60 * 5) {
		if (DBread('EchoExist', json_encode(array('name' => 'sk_user', 'id' => '*', 'whereid' => 'mail', 'whereinfo' => urlencode(base64_decode($mail))))) == '1') {
			// 使用邮箱查询用户信息
			foreach (DBread('EchoWHERE', json_encode(array('name' => 'sk_user', 'id' => '*', 'whereid' => 'mail', 'whereinfo' => urlencode(base64_decode($mail))))) as $row) {
				// 如果账号存在
				// 如果账号存在 验证账号是否封禁
				if ($row['ban'] == true) {
					// 如果账号未封禁 验证密码
					if (base64_decode($row['pwd']) == base64_decode($pwd)) {
						// 如果密码正确 验证权限组
						if ($row['ugroup'] == 'admin') {
							$arr = array('uid' => $row['uid'], 'group' => $row['ugroup'], 'name' => $row['name'], 'mail' => $row['mail'], 'login_time' => time());
							$json = md5_encrypt(base64_encode(json_encode($arr, JSON_UNESCAPED_UNICODE)), 'token');
							$_SESSION['token'] = $json;
							ob_clean();
							echo (json_encode(array('code' => '200', 'msg' => '登陆成功！', 'error' => ''), JSON_UNESCAPED_UNICODE));
						} else {
							echo (json_encode(array('code' => 'error', 'msg' => '', 'error' => '权限组错误！不是管理员！'), JSON_UNESCAPED_UNICODE));
						}
					} else {
						echo (json_encode(array('code' => 'error', 'msg' => '', 'error' => '密码错误'), JSON_UNESCAPED_UNICODE));
					}
				} else {
					echo (json_encode(array('code' => 'error', 'msg' => '', 'error' => '账号已被封禁'), JSON_UNESCAPED_UNICODE));
				}
			}
		} else {
			echo (json_encode(array('code' => 'error', 'msg' => '', 'error' => '账号不存在'), JSON_UNESCAPED_UNICODE));
		}
	} else {
		echo (json_encode(array('code' => 'error', 'msg' => '', 'error' => '请求超时'), JSON_UNESCAPED_UNICODE));
	}
}
?>