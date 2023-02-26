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
		// 初始化数据库
		$db = new DB;
		$db->db_config();
		// $db->db_write('sk_content', 'title,content,uid', "'test','test','1'");
		switch ($module) {
			case null:
				// 安装检查
				if (sys_status_install('read', '') == 'no') {
					ob_clean();
					include INS . 'index.php';
					exit;
				} else {
					ob_clean();
					sys_log();
					$db->db_read('sk_user', 'name', '', '');

					include CON . 'theme/' . set_theme() . '/index.php';
					exit;
				}

			case 'page':
				ob_clean();
				sys_log();
				$file = CON . 'theme/' . set_theme() . '/page/' . $action . '.php';
				if (file_exists($file)) {
					include $file;
					exit;
				} else {
					ob_clean();
					sys_log();
					require_once ROOT . 'sk-include/template/404.php';
					exit;
				}
			case 'sk-admin':
				ob_clean();
				sys_log();
				admin_power();
				require_once $require;
				exit;
			case 'sk-install':
				ob_clean();
				sys_log();
				include  INS . $action . '.php';
				exit;
			case 'test':

				require_once ROOT . $module . '/' . $action . '.php';
		}
		switch ($action) {
			case 'api':
				ob_clean();
				sys_log();
				api_verification();
				require_once $require;
				exit;
		}
	} else {
		ob_clean();
		sys_log();
		require_once ROOT . 'sk-include/template/404.php';
		echo $require;
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
	$is_headers = function_exists('getallheaders');
	$headers = array();
	if (!isset($is_headers)) #如果是nginx 
	{
		foreach ($_SERVER as $key => $value) {
			if ('HTTP_' == substr($key, 0, 5)) {
				$headers[str_replace('_', '-', substr($key, 5))] = $value;
			}
			if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
				$header['AUTHORIZATION'] = $_SERVER['PHP_AUTH_DIGEST'];
			} elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
				$header['AUTHORIZATION'] = base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']);
			}
			if (isset($_SERVER['CONTENT_LENGTH'])) {
				$header['CONTENT-LENGTH'] = $_SERVER['CONTENT_LENGTH'];
			}
			if (isset($_SERVER['CONTENT_TYPE'])) {
				$header['CONTENT-TYPE'] = $_SERVER['CONTENT_TYPE'];
			}
		}
	} else {
		$headers = getallheaders();
	}
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
class DB
{
	var $db_location;
	var $db_name;
	var $db_user;
	var $db_pwd;
	var $TableName; // 表名
	var $DBkey; //数据表键名
	var $DBinfo; //插入的数据
	var $Readinfo; //要读取的数据
	var $ReadCond; // 查询条件
	var $ReadOrder; // 排序方式
	var $ReadPage; //页数
	var $ReadPageSize; //条数

	// 数据库配置
	function db_config()
	{
		$data = file_get_contents(INC . 'config.json');    // 获取数据
		$arr = json_decode($data, true);    // 将获取到的 JSON 数据解析成数组
		$this->db_location = $arr['sql_location'];
		$this->db_name = $arr['sql_name'];
		$this->db_user = $arr['sql_user'];
		$this->db_pwd = $arr['sql_pwd'];
	}

	// 数据库地址
	function db_location()
	{
		echo $this->db_location;
	}

	// 数据库名称
	function db_name()
	{
		echo $this->db_name;
	}

	// 数据库账号
	function db_user()
	{
		echo $this->db_user;
	}

	// 数据库密码
	function db_pwd()
	{
		echo $this->db_pwd;
	}

	// 数据库连接
	function db_connect()
	{
		try {
			$conn = new mysqli("$this->db_location", $this->db_user, $this->db_pwd, $this->db_name);
			if (!$conn) {
				die(sys_error('数据库错误', '数据库连接失败，错误代码：' . mysqli_connect_error()));
			}
		} catch (PDOException $e) {
			sys_error('数据库错误', '数据库连接失败，错误代码：' . $e->getMessage());
		}
	}

	// 数据库写入
	function db_write($TableName, $DBkey, $DBinfo)
	{
		$conn = new mysqli("$this->db_location", $this->db_user, $this->db_pwd, $this->db_name);
		$sql = "INSERT INTO $TableName ($DBkey) VALUES ($DBinfo)";
		$conn->query($sql);
		echo $conn->error;
	}

	// 数据库查询
	function db_read($TableName, $Readinfo, $DBkey, $DBinfo, $ReadOrder = [], $ReadPage = 0, $ReadPageSize = 0)
	{
		$conn = new mysqli("$this->db_location", $this->db_user, $this->db_pwd, $this->db_name);

		$sql = "SELECT $Readinfo from `$TableName`";
		foreach ($conn->query($sql) as $row) {

			urldecode($row[$Readinfo]);
		}
	}

	// 数据库修改
	function db_change($table, $w_key, $w_content, $key, $content)
	{
		$conn = new mysqli("$this->db_location", $this->db_user, $this->db_pwd, $this->db_name);
		$sql = "UPDATE $table set $w_key='$w_content' where $key=$content";
		$conn->query($sql);
	}

	// 数据库删除
	function db_del($table, $key, $content)
	{
		$conn = new mysqli("$this->db_location", $this->db_user, $this->db_pwd, $this->sql_name);
		$sql = "delete from $table where $key=$content";
		$conn->query($sql);
	}
}

# --------------------------------## 接口相关 ##--------------------------------#

// 接口验证
function api_verification()
{
	$key = getallheaders()['key'];
	$sql = new DB;
	$sql->db_config();
	$conn = new PDO("mysql:dbname=$sql->db_name;host=$sql->db_location", $sql->db_user, $sql->db_pwd);
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
	$db = new DB;
	$db->db_config();
	$db->db_read('sk_setting', 'value', 'name', "'sys_key'");
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
	return $arr['name'];
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
