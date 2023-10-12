<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>安装 - SharkCMS内容管理系统</title>
	<!-- 样 式 文 件 -->
	<link rel="icon" href="/sk-include/static/img/logo.png">
	<link rel="stylesheet" href="/sk-include/static/layui/css/layui.css" />
	<link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />

</head>

<body class="layui-bg-gray sk-form">
	<div class="layui-panel card">
		<p class="title">欢迎使用<a class="main-color">SharkCMS</a>，请仔细阅读使用须知：</p>
		<ul>
			<li>1、在安装之前请确认数据库服务已开启，并确认是<a class="red">Mysql</a>数据库</li>
			<li>2、请确认当前系统安装在网站的<a class="red">一级目录（根目录）</a>，SharkCMS对于二级目录有兼容性问题</li>
			<li>3、在<a class="main-color">SharkCMS</a>使用过程中会<a class="red">收集系统信息</a>用于<a class="blue">统计分析</a>，同时也会用于<a class="red">云端接口授权</a>（为了保证云端接口不被随意调用），全程都将采用<a class="blue">加密通信</a>，安全问题可以放心</li>
			<li>4、在使用过程中请不要随意篡改程序（包括配置文件），否则可能导致系统出错或云端接口无法使用等</li>
		</ul><br>
		<p>如果你已了解并同意<a href="https://doc.sharkcms.cn/licenses.html" target="_blank">《云塔开源软件许可协议》</a>和
		<a href="https://doc.sharkcms.cn/privacy-policy.html" target="_blank">《云塔开源软件隐私权政策声明》</a>，请点击下方按钮。</p><br>
		<div class="button-next">
			<button type="button" style="width:200px;height:35px" onclick="jump()" class="layui-btn layui-btn-primary layui-btn-sm">我接受，并进行下一步操作</button>
		</div>
	</div>
	<p class="sk-copyright">
		<a target="_blank" href="https://www.sharkcms.cn">Powered by SharkCMS</a>
	</p>
	<script>
		function jump() {
			window.location.href = '/install/step/1'
		}
	</script>
</body>

</html>