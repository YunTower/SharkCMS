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
class Theme extends FrameWork
{
	public function __construct()
	{
		include_once INC . 'core/inc/db.php';
		$DB = new DB();

	}

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
	public static function TPath()
	{
		return CON . 'theme/' . Theme::ThemeName();
	}

	// 载入主题文件
	public static function import($url)
	{
		include Theme::TPath() . $url;
	}

	// 网站标题
	public static function SiteTitle()
	{
		echo '网站标题';
	}

	// 自定义页面标题
	public static function PageTitle()
	{
		static $title = null;
		$DB = new DB();
		echo $DB->table('sk_page')->where('name = "' . Route::getAction() . '"')->limit('1')->select('title')['title'];
	}

	// 自定义页面内容
	public static function PageContent($pid)
	{
		$DB = new DB();
		echo $DB->table('sk_page')->where('name = "' . $pid . '"')->limit('1')->select()['content'];
	}

	// 获取文章列表
	public static function getPostList()
	{

		$DB = new DB();
		return $DB->getAll('sk_content');
	}

	// 查询文章
	public static function PostSearch($cid)
	{
		$DB = new DB();
		return $DB->table('sk_content')->where('cid = ' . $cid)->select();
	}
}
