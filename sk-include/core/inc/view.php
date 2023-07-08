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


# --------------------------------## 主题组件 ##--------------------------------#
class View extends FrameWork
{
	public static $sTitle;
	public static $vArticle;
	public static $vName;
	public static $vUrl;
	public static $vKey;
	private $arr = array();
	private $config = array();

	public function __construct()
	{
		// 主题名称
		self::$vName = self::$_db->table('sk_setting')->where('name = "theme-name"')->select()['value'];

		// 当前主题路径
		self::$vUrl = CON . 'theme/' . self::$vName . '/';

		// 扫描目录
		$dir = scandir(CON . 'theme/');
		unset($dir[0]);
		unset($dir[1]);
		$dir = array_values($dir);

		// 生成路径
		foreach ($dir as $d) {
			$url = CON . 'theme/' . $d;
			$url = array($d => $url);
			$this->arr = $this->arr + $url;
		}

		// 读取配置
		foreach ($this->arr as $k => $v) {
			if (is_dir($v)) {
				$c = $v . '/theme.php';
				if (file_exists($c)) {
					$b = include_once $v . '/theme.php';
					$this->config = $this->config + array($k => $b);
				}
			}
		}
	}

	public static function view($page)
	{
		echo '<!-- Powered by SharkCMS v' . self::$_App['app']['Version'] . ' -->' . PHP_EOL;
		include_once self::$vUrl . 'page/' . $page . '.php';
	}

	public static function static($file)
	{
		echo self::getDomain() . '/sk-content/theme/' . self::$vName . '/' . $file;
	}

	// 文件加载
	public static function include($file)
	{
		include_once self::$vUrl . $file;
	}

	public static function get_header()
	{
		include self::$vUrl . 'header.php';
	}

	public static function get_sidebar()
	{
		$f = self::$vUrl . 'sidebar.php';
		if (file_exists($f)) {
			include $f;
		} else {
			self::Error('系统错误', '主题文件【sidebar.php】不存在');
		}
	}

	public static function get_footer()
	{
		include self::$vUrl . 'footer.php';
	}

	public static function vSet($name)
	{
		echo self::$_db->table('sk_theme')->where("name = '$name'")->select()['value'];
	}

	public static function query($a)
	{
		switch ($a) {
			case 'article':
				return self::$_db->getAll('sk_content');
				break;
			case 'tag':
				$key = self::$vKey;
				$cid = self::$_db->table('sk_tag')->where("name = '$key'")->select()['cid'];
				return array(self::$_db->table('sk_content')->where('cid = ' . $cid)->select());
			case 'category':
				$key = self::$vKey;
				$cid = self::$_db->table('sk_category')->where("name = '$key'")->select()['cid'];
				return array(self::$_db->table('sk_content')->where('cid = ' . $cid)->select());
			default:
				self::Error('Error', '在调用模板方法时产生错误【View::query】，没有方法【' . $a . '】');
				break;
		}
	}

	public static function count($a)
	{
		$key = self::$vKey;
		switch ($a) {
			case 'tag':
				echo self::$_db->table('sk_tag')->where("name = '$key'")->count();
				break;
			case 'category':
				echo self::$_db->table('sk_category')->where("name = '$key'")->count();
				break;
			default:
				self::Error('Error', '在调用模板方法时产生错误【View::count】，没有方法【' . $a . '】');
				break;
		}
	}
}
