<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>安装中 - SharkCMS </title>
    <link rel="stylesheet" href="<?php echo Route::Domain(); ?>/sk-admin/component/pear/css/pear.css" />
    <link rel="stylesheet" href="<?php echo Route::Domain(); ?>/sk-admin/admin/css/other/result.css" />
</head>

<body class="pear-container">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="result">

                <h2 class="title">安装中</h2>
                <div class="content" style="padding: 30px;">
                    <?php

                    $config = include_once INC . 'config.php';
                    if (@$config['INSTALL'] != null) {
                        sys_error('安装已锁定', '系统已安装成功，无需再次安装<br>如需再次安装，请手动清空“/sk-include/config.php”文件');
                        exit;
                    } else {

                        $key = 'sharkcms';
                        $dbhost = $_POST['dbhost'];
                        $dbname = $_POST['dbname'];
                        $dbuser = $_POST['dbuser'];
                        $dbpwd = $_POST['dbpwd'];
                        $mail = $_POST['adminmail'];
                        $adminmail = urlencode($mail);
                        $adminname = urlencode($_POST['adminname']);
                        $adminpwd = base64_encode($_POST['adminpwd']);

                        // 创建数据表
                        // content
                        $conn = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbuser);
                        // 检测连接
                        if (!$conn) {
                            die("数据库连接失败，错误代码： " . mysqli_connect_error());
                        } else {
                            // 清空数据库配置
                            file_put_contents(INC . 'config.php', '');


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
                            `name` VARCHAR(32) NOT NULL,
                            `comment` char(1) NOT NULL,
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
                            `name` VARCHAR(50) NOT NULL,
                            `title` VARCHAR(150) NOT NULL,
                            `content` TEXT NOT NULL,
                            `status` VARCHAR(64),
                            `pwd` VARCHAR(32),
                            `comment` char(1) NOT NULL,
                            `created` TIMESTAMP
                            )";

                            // user
                            $sql_4 = "CREATE TABLE sk_user (
                            `uid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `name` VARCHAR(32) NOT NULL,
                            `pwd` VARCHAR(32) NOT NULL,
                            `mail` VARCHAR(150) NOT NULL,
                            `avatar` VARCHAR(150),
                            `ugroup` VARCHAR(64) NOT NULL,
                            `ban` VARCHAR(32),
                            `logintime` VARCHAR(64),
                            `created` TIMESTAMP
                            )";

                            // theme
                            $sql_5 = "CREATE TABLE sk_theme (
                            `tid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                            `name` VARCHAR(150) NOT NULL,
                            `value` VARCHAR(150),
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

                                        // 写入数据库配置
                                        $dbconfig =
"<?php\n 
    return [\n
        'INSTALL'=>'ok',\n
        'KEY'=>'" . System::CreateKey(16) . "',\n
        'DB_CONNECT' => [\n
        'host' => '" . $dbhost .
            "',\n'username' => '" . $dbuser .
            "',\n'password' => '" . $dbpwd .
            "',\n'dbname' => '" . $dbname .
            "',\n
            'port' => '3306',\n
        ],\n
        'DB_CHARSET' => 'utf8'\n
    ];\n
?>";
                                        $file = INC . 'config.php';
                                        $fp = fopen($file, "a");
                                        $txt = $dbconfig . "\n";
                                        fputs($fp, $txt);
                                        fclose($fp);

                                        // 写入初始数据
                                        $time = date('YmdHi');
                                        $w_post = json_encode(array('name' => 'sk_content', 'id' => 'title,introduction,content,uid,name,comment', 'info' => "'Hello SharkCMS','Hello World','当你看到这篇文章的时候，说明SharkCMS已经安装成功了，删除这篇文章，开始创作吧！','1','$adminname',true"));
                                        $w_user = json_encode(array("name" => "sk_user", "id" => "name,pwd,mail,ugroup,ban,logintime", "info" => "'$adminname','$adminpwd', '$adminmail', 'admin','false','$time'"));

                                        if (DBwrite($w_post) == true && DBwrite($w_user) == true) {

                                            echo '数据库安装成功';
                                        } else {
                                            sys_error('数据库错误', mysqli_error($conn));
                                        }
                                    }
                                }
                            } else {
                                echo '系统安装失败：' . mysqli_error($conn) . '<br>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="action">
                    <a href="<?php echo Route::Domain(); ?>/index.php/sk-admin/"><button class="pear-btn pear-btn-primary">进入后台</button></a>
                    <a href="<?php echo Route::Domain(); ?>/index.php/sk-install/"><button onclick="again()" class="pear-btn">重新安装</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo Route::Domain(); ?>/sk-admin/component/layui/layui.js"></script>
    <script src="<?php echo Route::Domain(); ?>/sk-admin/component/pear/pear.js"></script>
    <script>
        function again() {
            alert('如需重新安装，请先清空 “/sk-include/config.php” 文件，并删除数据库中前缀为 “sk-” 的数据表')
        }
    </script>
</body>

</html>