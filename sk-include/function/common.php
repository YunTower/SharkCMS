<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.icu
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */


# --------------------------------## 系统相关 ##--------------------------------#

// 网站域名
function sys_domain()
{
	$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
	return $http_type . $_SERVER['HTTP_HOST'];
}

// 系统路由
function sys_route()
{
	// 获取请求的URI
	$request_uri = $_SERVER['REQUEST_URI'];
	// 获取请求的入口文件
	$script_name = $_SERVER['SCRIPT_NAME'];
	// 获取URL中的模块、方法和查询字符串
	$request = str_replace($script_name, '', $request_uri);
	$request = ltrim($request, '/');
	// 将查询字符串分离
	$request_array = explode('?', $request);
	// 将模块和方法存放在数组中
	$module_action = $request_array[0];
	if (empty($module_action)) {
		$module = '';
		$action = 'index';
	} else {
		$module_action = explode('/', $module_action);
		// 获取模块
		if (isset($module_action[0]) && !empty($module_action[0])) {
			$module = $module_action[0];
		} else {
			$module = 'index';
		}
		// 获取方法
		if (isset($module_action[1]) && !empty($module_action[1])) {
			$action = $module_action[1];
		} else {
			$action = 'index';
		}
	}

	// 返回请求的资源
	$require = ROOT . $module .  '/' . $action . '.php';
	if (file_exists($require)) {
		if ($module == null) {
			// 安装检查
			if (sys_status_install('read', '') == 'no') {
				ob_clean();
				include INS . 'index.php';
				exit;
			} else {
				ob_clean();
				sys_log();
				include CON . 'theme/' . set_theme() . '/index.php';
				exit;
			}
		} else if ($module == 'sk-admin') {
			ob_clean();
			sys_log();
			admin_power();
			require_once $require;
			exit;
		} else if ($action == 'api') {
			ob_clean();
			sys_log();
			api_verification();
			require_once $require;
			exit;
		} else if ($module == 'sk-install') {
			ob_clean();
			sys_log();
			include  INS . $action . '.php';
			exit;
		}
	} else if ($module == 'page') {
		ob_clean();
		sys_log();
		$file = CON . 'theme/' . set_theme() . '/page/' . $action . '.php';
		if (file_exists($file)) {
			include CON . 'theme/' . set_theme() . '/page/' . $action . '.php';
			exit;
		} else {
			ob_clean();
			sys_log();
			require_once ROOT . 'sk-include/template/404.php';
			exit;
		}
	} else if ($module == 'sk-content') {
		ob_clean();
		sys_log();
		require_once ROOT . 'sk-include/template/403.php';
		exit;
	} else {
		ob_clean();
		sys_log();
		require_once ROOT . 'sk-include/template/404.php';
		exit;
	}
}

// 错误函数
if (!function_exists('error')) {
	function sys_error($msg, $errstr)
	{
		ob_clean();
		$error_code = '[' . $msg . ']  ' . $errstr;
		include INC . 'template/error.php';
		$log_error = $errstr;
		sys_log_error($log_error);
		exit;
	}
	// set_error_handler('error');
}

// 系统安装状态
function sys_status_install($method, $status)
{
	if ($method == 'read' || $status == '') {
		$url = file_get_contents(CON . 'temp/install_keep.json');
		$arr = json_decode($url, true);
		return  $arr['status'];
	} else if ($method == 'install' || $status == 'ok') {
		file_put_contents(CON . 'temp/install_keep.json', '');
		$content = json_encode(array('status' => 'ok', 'time' => date('Y-m-d H:i:s')), JSON_UNESCAPED_UNICODE);
		$file = CON . 'temp/install_Keep.json';
		$fp = fopen($file, "a");
		$txt = $content;
		fputs($fp, $txt);
		fclose($fp);
	} else {
		sys_error('系统错误', '系统安装状态：查询方法错误或无此方法');
	}
}

// 系统访问日志
function sys_log()
{
	// 获取日志信息
	$log_page = sys_domain() . $_SERVER['REQUEST_URI'];
	$log_time = date("Y-m-d H:i:s");
	$log_name = 'log_' . date("Ymd");
	$log_user = $_SERVER['REMOTE_ADDR'];
	if (file_exists($_SERVER['REQUEST_URI'])) {
		$log_code = '200';
	} else {
		$log_code = '404';
	}
	// 声明数组
	$error_info = json_encode(array('time' => $log_time, 'code' => $log_code, 'page' => $log_page, 'user' => $log_user), JSON_UNESCAPED_UNICODE);
	// 文件位置
	$log_file = ROOT . "sk-content/temp/log/$log_name.json";
	// 写入
	$fp = fopen($log_file, "a");
	$txt = $error_info . "n";
	fputs($fp, $txt);
	fclose($fp);
}

// 系统错误日志
function sys_log_error($log_error)
{
	// 获取日志信息
	$log_page = sys_domain() . $_SERVER['REQUEST_URI'];
	$log_time = date("Y-m-d H:i:s");
	$log_name = 'error_' . date("Ymd");
	$log_user = $_SERVER['REMOTE_ADDR'];
	if (file_exists($_SERVER['REQUEST_URI'])) {
		$log_code = '200';
	} else {
		$log_code = '404';
	}
	// 声明数组
	$arr = array('time' => $log_time, 'code' => $log_code, 'page' => $log_page, 'error' => $log_error, 'user' => $log_user);
	$error_info = json_encode($arr, JSON_UNESCAPED_UNICODE);
	// 文件位置
	$log_file = ROOT . "sk-content/temp/log/$log_name.json";
	// 写入
	$fp = fopen($log_file, "a");
	$txt = $error_info . "\n";
	fputs($fp, $txt);
	fclose($fp);
}

// 目录删除
function sys_deldir($path)
{
	if (is_dir($path)) {
		$p = scandir($path);
		foreach ($p as $val) {
			if ($val != '.' && $val != '..') {
				if (is_dir($path . '/' . $val)) {
					sys_deldir($path . '/' . $val);
					@rmdir($path . '/' . $val);
				} else {
					unlink($path . '/' . $val);
				}
			}
		}
	}
}

// 随机生成密匙
function sys_createkey($length)
{
	$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$len = strlen($str) - 1;
	$randstr = '';
	for ($i = 0; $i < $length; $i++) {
		$num = mt_rand(0, $len);
		$randstr .= $str[$num];
	}
	return $randstr;
}

// 获取请求头
function getHeader($c)
{
	if (!function_exists('getallheaders')) {
		function getallheaders()
		{
			foreach ($_SERVER as $name => $value) {
				if (substr($name, 0, 5) == 'HTTP_') {
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
				}
			}
			return $headers;
		}
	}
	print_r(getallheaders()[$c]);
}

// 版本类型
function sys_en_t()
{
	if (App_T == 'release') {
		echo '发行版';
	} else if (App_T == 'demo') {
		echo '演示版';
	} else if (App_T == 'beta') {
		echo '测试版';
	} else if (App_T == 'dev') {
		echo '开发版';
	} else if (App_T == 'rc') {
		echo '预发布版';
	} else {
		echo '未知版本';
	}
}

// 解释引擎
function sys_en_engine()
{
	if (!isset($_SERVER['SERVER_SOFTWARE'])) {
		echo '未检测到解释引擎类型';
	}
	$webServer = strtolower($_SERVER['SERVER_SOFTWARE']);
	if (strpos($webServer, 'apache') !== false) {
		echo 'Apache';
	} elseif (strpos($webServer, 'microsoft-iis') !== false) {
		echo 'IIS';
	} elseif (strpos($webServer, 'nginx') !== false) {
		echo 'Nginx';
	} elseif (strpos($webServer, 'lighttpd') !== false) {
		echo 'Lighttpd';
	} elseif (strpos($webServer, 'kangle') !== false) {
		echo 'Kangle';
	} elseif (strpos($webServer, 'caddy') !== false) {
		echo 'Saddy';
	} else {
		echo $webServer;
	}
}

# --------------------------------## 加解密相关 ##--------------------------------#

// 加密
function  md5_encrypt($str, $key)
{
	srand((float)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for ($i = 0; $i < strlen($str); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr] . ($str[$i] ^ $encrypt_key[$ctr++]);
	}
	return  base64_encode(md5_key($tmp, $key));
}

// 解密
function  md5_decrypt($str, $key)
{
	$str = md5_key(base64_decode($str), $key);
	$tmp = '';
	for ($i = 0; $i < strlen($str); $i++) {
		$md5 = $str[$i];
		$tmp .= $str[++$i] ^ $md5;
	}
	return  $tmp;
}

// 辅助
function  md5_key($str, $encrypt_key)
{
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for ($i = 0; $i < strlen($str); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $str[$i] ^ $encrypt_key[$ctr++];
	}
	return  $tmp;
}
# --------------------------------## 数据库相关 ##--------------------------------#
class sql
{
	var $sql_location;
	var $sql_name;
	var $sql_user;
	var $sql_pwd;

	// 数据库配置
	function sql_config()
	{
		$data = file_get_contents(INC . 'config.json');    // 获取数据
		$arr = json_decode($data, true);    // 将获取到的 JSON 数据解析成数组
		$this->sql_location = $arr['sql_location'];
		$this->sql_name = $arr['sql_name'];
		$this->sql_user = $arr['sql_user'];
		$this->sql_pwd = $arr['sql_pwd'];
	}

	// 数据库地址
	function sql_location()
	{
		echo $this->sql_location;
	}

	// 数据库名称
	function sql_name()
	{
		echo $this->sql_name;
	}

	// 数据库账号
	function sql_user()
	{
		echo $this->sql_user;
	}

	// 数据库密码
	function sql_pwd()
	{
		echo $this->sql_pwd;
	}

	// 数据库连接
	function sql_connect()
	{
		try {
			$conn = new PDO("mysql:dbname=$this->sql_name;host=$this->sql_location", $this->sql_user, $this->sql_pwd);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if (!$conn) {
				die(sys_error('数据库错误', '数据库连接失败，错误代码：' . mysqli_connect_error()));
			}
		} catch (PDOException $e) {
			sys_error('数据库错误', '数据库连接失败，错误代码：' . $e->getMessage());
		}
	}

	// 数据库写入
	function sql_write($table, $key, $info)
	{
		$conn = new PDO("mysql:dbname=$this->sql_name;host=$this->sql_location", $this->sql_user, $this->sql_pwd);
		$sql = "insert into $table ($key) values ($info)";
		$conn->exec($sql);
	}

	// 数据库修改
	function sql_change($table, $w_key, $w_content, $key, $content)
	{
		$conn = new PDO("mysql:dbname=$this->sql_name;host=$this->sql_location", $this->sql_user, $this->sql_pwd);
		$sql = "update $table set $w_key='$w_content' where $key=$content";
		$conn->exec($sql);
	}

	// 数据库查询
	function sql_read($table, $read, $key, $content)
	{
		$conn = new PDO("mysql:dbname=$this->sql_name;host=$this->sql_location", $this->sql_user, $this->sql_pwd);
		$sql = "select $read from $table where $key=$content";
		foreach ($conn->query($sql) as $row) {
			if ($row[$read] == null) {
				echo '<a style="marign:20px">查询失败，数据为空</a>';
			} else {
				echo urldecode($row[$read]);
			}
		}
	}

	// 数据库删除
	function sql_del($table, $key, $content)
	{

		$conn = new PDO("mysql:dbname=$this->sql_name;host=$this->sql_location", $this->sql_user, $this->sql_pwd);
		$sql = "delete from $table where $key=$content";
		$conn->exec($sql);
	}
}

# --------------------------------## 接口相关 ##--------------------------------#

// 接口验证
function api_verification()
{
	$key = getallheaders()['key'];
	$sql = new sql;
	$sql->sql_config();
	$conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
	$sql = "select value from sk_setting where name='sys_key'";
	foreach ($conn->query($sql) as $row) {
		$value = $row['value'];
	}
	if ($value != $key) {
		ob_clean();
		echo json_encode(array('code' => 0, 'msg' => '权限验证失败，密匙错误'), JSON_UNESCAPED_UNICODE);
		exit;
	}
}

function get_key()
{
	$sql = new sql;
	$sql->sql_config();
	$sql->sql_read('sk_setting', 'value', 'name', "'sys_key'");
}

# --------------------------------## 后台相关 ##--------------------------------#

// 后台鉴权
function admin_power()
{
	if (!defined('App_N')) {
		Header('Location: ../../index.php/sk-admin/login');
		exit;
	} else {
		// 权限验证
		if (!isset($_COOKIE["login_status"])) {
			ob_clean();
			include ROOT . '/sk-admin/login.php';
			exit;
		} else {
			// 解析token
			$json = base64_decode(md5_decrypt(($_COOKIE['user_token']), 'sharkcms-user-token'));
			$arr = json_decode($json, true);
			// 如果用户组不是admin
			if ($arr['group'] != 'admin') {
				ob_clean();
				include ROOT . '/sk-admin/login.php';
				exit;
			} else {
				// 如果超时
				if ($arr['login_out'] - $arr['login_time'] > 60 * 60 * 2) {
					ob_clean();
					unset($_SESSION['login_token']);
					setcookie("login_token", "", time() - 60 * 60 * 100);
					include ROOT . '/sk-admin/login.php';
					exit;
				}
			}
		}
	}
}

// 用户信息
function admin_user_name()
{
	// 解析token
	$json = base64_decode(md5_decrypt(($_COOKIE['user_token']), 'sharkcms-user-token'));
	$arr = json_decode($json, true);
	return $arr['*'];
}

# --------------------------------## 主题相关 ##--------------------------------#

// 当前主题
function set_theme()
{
	return 'default';
	// $sql=new sql;
	// $sql->sql_config();
	// $sql->sql_read('sk_set_theme','theme','id','set_theme');
}

// 主题名称

// 主题位置

// 主题版本

// 页面

// 菜单

// 自定义代码
