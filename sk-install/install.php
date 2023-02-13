<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>安装中 - SharkCMS </title>
    <link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/component/pear/css/pear.css" />
    <link rel="stylesheet" href="<?php echo sys_domain(); ?>/sk-admin/admin/css/other/result.css" />
</head>

<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="result">

                <h2 class="title">安装中</h2>
                <div class="content" style="padding: 30px;">
                    <?php

                    $key = 'sharkcms';

                    $dbhost = $_POST['dbhost'];
                    $dbname = $_POST['dbname'];
                    $dbuser = $_POST['dbuser'];
                    $dbpwd = $_POST['dbpwd'];
                    $mail = $_POST['adminmail'];
                    $adminmail = urlencode($mail);
                    $adminname = urlencode($_POST['adminname']);
                    $adminpwd = urlencode(md5_encrypt($_POST['adminpwd'], $key));

                    // 创建数据表
                    // content
                    $conn = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbuser);
                    // 检测连接
                    if (!$conn) {
                        die("数据库连接失败，错误代码： " . mysqli_connect_error());
                    } else {
                        // 清空数据库配置
                        file_put_contents(INC . 'config.json', '');
                        // 写入配置
                        $arr = array('sql_location' => $dbhost, 'sql_name' => $dbname, 'sql_user' => $dbuser, 'sql_pwd' => $dbpwd);
                        $content = json_encode($arr, JSON_UNESCAPED_UNICODE);
                        $file = INC . "config.json";
                        $fp = fopen($file, "a");
                        $txt = $content;
                        fputs($fp, $txt);
                        fclose($fp);

                        // content
                        $sql_1 = "CREATE TABLE sk_content (
                            `cid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `title` VARCHAR(40) NOT NULL,
                            `introduction` VARCHAR(50),
                            `content` TEXT NOT NULL,
                            `cover` VARCHAR(190),
                            `power` VARCHAR(10), 
                            `type` VARCHAR(10),
                            `status` VARCHAR(10),
                            `password` VARCHAR(32),
                            `uid` VARCHAR(10) NOT NULL,
                            `created` TIMESTAMP
                            )";

                        // comment
                        $sql_2 = "CREATE TABLE sk_comment (
                            `coid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `cid` INT(6) NOT NULL,
                            `content` TEXT NOT NULL,
                            `authorid` INT(16) NOT NULL,
                            `status` VARCHAR(16) NOT NULL,
                            `uid` VARCHAR(10) NOT NULL,
                            `parent` int(10),
                            `created` TIMESTAMP
                            )";

                        // page
                        $sql_3 = "CREATE TABLE sk_page (
                            `pid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `title` VARCHAR(150) NOT NULL,
                            `slug` VARCHAR(150) NOT NULL,
                            `status` VARCHAR(64),
                            `password` VARCHAR(32),
                            `allowComment` char(1) NOT NULL,
                            `created` TIMESTAMP
                            )";

                        // user
                        $sql_4 = "CREATE TABLE sk_user (
                            `uid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `name` VARCHAR(99) NOT NULL,
                            `password` VARCHAR(99) NOT NULL,
                            `mail` VARCHAR(99) NOT NULL,
                            `avatar` VARCHAR(99),
                            `ugroup` VARCHAR(64) NOT NULL,
                            `status` VARCHAR(32),
                            `created` TIMESTAMP
                            )";

                        // theme
                        $sql_5 = "CREATE TABLE sk_theme (
                            `tid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `name` VARCHAR(32) NOT NULL,
                            `value` VARCHAR(88),
                            `created` TIMESTAMP
                            )";

                        // setting
                        $sql_6 = "CREATE TABLE sk_setting (
                            `name` VARCHAR(32) NOT NULL,
                            `value` VARCHAR(999),
                            `created` TIMESTAMP
                            )";

                        // 分次安装（解决一起安装，之后的表不显示报错的问题）
                        if (mysqli_query($conn, $sql_1)) {
                            if (mysqli_query($conn, $sql_2)) {
                                if (mysqli_query($conn, $sql_3)) {
                                    echo '数据表 sk_content、sk_comment、sk_page 安装成功！<br>';
                                }
                            }
                        } else {
                            echo '系统安装失败：' . mysqli_error($conn) . '<br>';
                        }
                        if (mysqli_query($conn, $sql_4)) {
                            if (mysqli_query($conn, $sql_5)) {
                                if (mysqli_query($conn, $sql_6)) {

                                    // 安装成功
                                    echo '数据表 sk_user、sk_theme、sk_setting 安装成功！<br>';
                                    echo '数据表创建完毕，正在写入初始数据...<br>';
                                    $sys_key=sys_createkey(16);
                                    $sql = new sql;
                                    $sql->sql_config();
                                    $sql->sql_write('sk_user', 'name,password,mail,ugroup,status', "'$adminname','$adminpwd', '$adminmail', 'admin','0'");
                                    $sql->sql_write('sk_content', 'title,content,introduction,uid', "'Hello SharkCMS','当你看到这篇文章的时候，说明SharkCMS已经安装成功了，删除这篇文章，开始创作吧！','Hello World','1'");
                                    $sql->sql_write('sk_setting', 'name,value', "'sys_key','$sys_key'");

                                    echo '初始数据写入成功！<br>';
                                    echo '系统安装成功！';
                                    // 修改安装状态
                                    sys_status_install('install', 'ok');

                                    // 删除安装目录
                                    $path = './sk-install/';
                                    function deldir($path)
                                    {
                                        if (is_dir($path)) {
                                            $p = scandir($path);
                                            foreach ($p as $val) {
                                                if ($val != '.' && $val != '..') {
                                                    if (is_dir($path . '/' . $val)) {
                                                        deldir($path . $val);
                                                        @rmdir($path . $val);
                                                    } else {
                                                        unlink($path . '/' . $val);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    deldir($path);
                                }
                            }
                        } else {
                            echo '系统安装失败：' . mysqli_error($conn) . '<br>';
                        }
                    }
                    ?>
                </div>
                <div class="action">
                    <a href="<?php echo sys_domain(); ?>/index.php/sk-admin/"><button class="pear-btn pear-btn-primary">进入后台</button></a>

                    <a href="<?php echo sys_domain(); ?>/index.php/sk-install/"><button class="pear-btn">重新安装</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo sys_domain(); ?>/sk-admin/component/pear/pear.js"></script>
</body>

</html>