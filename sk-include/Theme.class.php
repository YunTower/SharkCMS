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


# --------------------------------## 主题相关 ##--------------------------------#
class Theme
{


	// 页面类型
	public function PageType()
	{
	}

	// 主题名称
	public static function ThemeName()
	{
		return 'default/';
	}

	// 主题路径
	public static function ThemeURL()
	{
		return CON . 'theme/' . Theme::ThemeName();
	}

	// 载入主题文件
	public static function import($url)
	{
		include Theme::ThemeURL() . $url;
	}

	// 载入静态文件
	public static function Static($url)
	{
		echo Route::Domain() . '/sk-content/theme/' . Theme::ThemeName() . $url;
	}

	// 自定义页面标题
	public static function PageTitle()
	{
		static $title = null;
		$DB = new DB();
		$config = include Theme::ThemeURL() . 'config.php';
		$title = $config['PageTitle'][Route::getAction()];
		if ($title) {
			echo $title;
		} else {
			echo $DB->table('sk_page')->where('name = "' . Route::getAction() . '"')->limit('1')->select('title')[0][0];
		}
	}

	// 自定义页面内容
	public static function PageContent()
	{
		$DB = new DB();
		echo $DB->table('sk_page')->where('name = "' . Route::getAction() . '"')->limit('1')->select('content')[0][0];
	}
}
