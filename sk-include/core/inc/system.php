<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.cn
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */


# --------------------------------## 系统相关 ##--------------------------------#

/**
 * @name: 路由类
 * @desc: SharkCMS系统主路由，万物的根基
 * @author: fish
 * @date: 20230429
 **/
class Route extends FrameWork
{
	// 获取域名
	public static function Domain()
	{
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		return $http_type . $_SERVER['HTTP_HOST'];
	}

	// 获取模块
	public static function getModule()
	{
		return FrameWork::controller_action()['controller'];FrameWork::controller_action()['controller'];
	}

	// 获取方法
	public static function getAction()
	{
		return FrameWork::controller_action()['action'];
	}

	// 获取参数
	public static function getData()
	{
		return FrameWork::controller_action()['data'];
	}

	
}


/**
 * @name: 系统类
 * @desc: 系统
 * @author: camellia
 * @date: 20230501
 **/
class System extends FrameWork
{

	// 获取配置
	public static function getConfig($name)
	{
		static $config = null;
		if (!$config) {
			$config = require INC . 'config.php';
		}
		return isset($config[$name]) ? $config[$name] : null;
	}

	// 错误函数
	public static function ERROR($title, $error)
	{
		$title = $title;
		$error = $error;
		include INC . 'error/error.php';
		exit;
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
	public static function CreateKey($length)
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

# --------------------------------## 后台相关 ##--------------------------------#

// 后台鉴权
function admin_power()
{
	if (!defined('App_N')) {
		Header('Location: ../../index.php/sk-admin/login');
		exit;
	} else {
		// 权限验证
		if (!isset($_SESSION["user_token"])) {
			ob_clean();
			include ROOT . '/sk-admin/login.php';
			exit;
		} else {
			// 解析token
			$json = base64_decode(md5_decrypt(($_SESSION['user_token']), 'sharkcms-user-token'));
			$arr = json_decode($json, true);
			// 如果用户组不是admin
			if ($arr['group'] != 'admin') {
				ob_clean();
				include ROOT . '/sk-admin/login.php';
				exit;
			} else {
			}
		}
	}
}

// 用户信息
function admin_user_name()
{
	// 解析token
	$json = base64_decode(md5_decrypt(($_SESSION['user_token']), 'sharkcms-user-token'));
	$arr = json_decode($json, true);
	return $arr['name'];
}

// 接口key
function admin_api_key()
{
}
