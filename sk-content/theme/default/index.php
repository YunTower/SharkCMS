<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>网站标题</title>
    <?php include_once Theme::TPath() . 'header.php' ?>
</head>

<body>


    <div class="left">
        <div class="logo">
            <img src="<?php echo $data['img_logo'] ?>" />
            <div class="title">
                <h3>fish</h3>
            </div>
        </div>
        <div class="footer">
            <div><a target="_blank" href="https://sharkcms.cn/">Powered by SharkCMS</a></div>
        </div>
    </div>

    <div class="top">
        <div class="nav">
            <li>
                <a class="current" target="_self" href="../../index">首页</a>
            </li>
            <li>
                <a class="" target="_self" href="../../page/about">关于</a>
            </li>
        </div>
    </div>

    <?php include_once Theme::TPath() . 'home_right.php' ?>
    {import[footer]}

</body>

</html>