<?php ob_clean(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统错误</title>
    <link rel="icon" href="/sk-include/static/img/logo.png">
    <link rel="stylesheet" href="/sk-include/static/css/sharkcms.min.css" />
    <style>
        body {
            font-size: 12px;
            background-color: #f4f5f5;
        }
    </style>
</head>

<body class="sk-error">
    <div class="main">
        <div class="title"><?php echo implode($title) ?></div>
        <p class="content"><?php echo implode($msg) ?></p>
    </div>
    <p class="sk-copyright">
        <a target="_blank" href="https://www.sharkcms.cn">Powered by SharkCMS</a>
    </p>
</body>


</html>
<?php
use FrameWork\FrameWork;
if (FrameWork::getController()=='api'){
    ob_clean();
    exit(json_encode(['code'=>500,'msg'=>$msg]));
}
exit(); ?>