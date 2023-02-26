<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>登陆账号 - SharkCMS</title>
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
	<link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/login.css" />
</head>
<!-- 代 码 结 构 -->

<body background="<?php echo sys_domain(); ?>/sk-admin/admin/images/background.svg" style="background-size: cover;">
	<form class="layui-form" action="javascript:void(0);">
		<div class="layui-form-item">
			<img class="logo" src="<?php echo sys_domain(); ?>/sk-admin/admin/images/logo.png" />
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
				<img src="<?php echo sys_domain(); ?>/sk-admin/admin/images/captcha.gif" class="codeImage" />
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
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-include/static/libs/jquery.min.js"></script>
	<script src="<?php echo sys_domain(); ?>/sk-include/static/js/sharkcms.base64.js"></script>
	<script>
		layui.use(['form', 'button', 'popup'], function() {
			var form = layui.form;
			var button = layui.button;
			var popup = layui.popup;
			form.on('submit(login)', function() {
				var get_mail = $('#mail').val();
				var get_pwd = $('#pwd').val();
				var mail = Base64.encode(get_mail)
				var pwd = Base64.encode(get_pwd);
				layer.msg('登陆请求中')
				var data = JSON.stringify({
					mail: mail,
					pwd: pwd
				});

				$.ajax({
					type: "POST",
					url: "../../index.php/sk-admin/login?t=" + Math.floor(Date.now() / 1000),
					dataType: "json",
					data: data,
					contentType: "application/jsoan",
					success: function(data) {
						var obj = JSON.parse(JSON.stringify(data));
						console.log(obj);
						if (obj.status == '') {
							layer.alert(obj.msg)
						} else if (obj.status == 'ok') {
							layer.msg(obj.msg);
							location.href = '../../index.php/sk-admin/index'
						} else {
							layer.alert(obj.msg)
						}
					}
				});
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
	$get_t = $_GET['t'];
	$sys_t = time();
	if (date('YmdHis', $get_t) - date('YmdHis', $sys_t) > '100') {
		echo json_encode(array('code' => 'time out', 'msg' => '请求超时'), JSON_UNESCAPED_UNICODE);
	} else {
		$get_json = file_get_contents("php://input");
		$arr = json_decode($get_json, true);
		$key = 'sharkcms';
		$pwd = urlencode(md5_encrypt(base64_decode($arr['pwd']), $key));
		$mail = urlencode(base64_decode($arr['mail']));
		$sql = new sql;
		$sql->sql_config();
		try {
			$conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "select * from `sk_user` where mail='$mail'";
			$res = $conn->query($sql);
			foreach ($res as $row) {
				// 解码数据
				$sql_pwd = md5_decrypt(urldecode($row['password']), $key);
				$get_pwd = md5_decrypt(urldecode($pwd), $key);
				// 权限组匹配
				if ($row['ugroup'] == 'admin') {
					// 密码匹配
					if ($sql_pwd == $get_pwd) {

						// 生成json数据
						$arr = array('uid' => $row['uid'], 'group' => $row['ugroup'], 'name' => $row['name'], 'mail' => $row['mail'], 'login_time' => date('YmdHis'), 'login_out' => time() + 60 * 60 * 24 * 30);
						$json = md5_encrypt(base64_encode(json_encode($arr, JSON_UNESCAPED_UNICODE)), 'sharkcms-user-token');

						// 修改数据库登陆时间
						$time = date('YmdHi');
						$uid = $row['uid'];
						$sql = new sql;
						$sql->sql_config();
						$sql->sql_change('sk_user', 'logintime', "$time", 'uid', "$uid");

						// 写入token&cookie
						setcookie("login_status", "ok", time() + 60 * 60 * 2);
						setcookie("user_token", $json, time() + 60 * 60 * 2);
						$_SESSION['user_token'] = $json;
						ob_clean();
						echo json_encode(array('code' => '200', 'msg' => '登陆成功', 'status' => 'ok'), JSON_UNESCAPED_UNICODE);
					} else if ($sql_pwd == null) {
						ob_clean();
						echo json_encode(array('msg' => '账号不存在'), JSON_UNESCAPED_UNICODE);
					} else {
						ob_clean();
						echo json_encode(array('code' => '200', 'msg' => '登陆失败，账号或密码错误', 'status' => ''), JSON_UNESCAPED_UNICODE);
					}
				} else {
					ob_clean();
					echo json_encode(array('msg' => '此账号没有权限登陆后台'), JSON_UNESCAPED_UNICODE);
				}
			}
		} catch (PDOException $e) {
			echo json_encode(array('code' => 0, 'msg' => '数据库查询失败，错误代码：' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
		}
	}
}
?>