<?php ob_clean(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系统错误</title>
    <style>
        html {
            font-size: 12px;
            background-color: #f4f5f5;
        }

        .main {
            position: absolute;
            left: 50%;
            top: 30%;
            max-width: 624px;
            width: 86%;
            background-color: #fff;
            transform: translateX(-50%);
            padding: 30px 40px 0;
            box-sizing: border-box;
            border: 1px solid #e5e6eb;
            border-radius: 2px;
        }

        .title {
            margin: 0;
            font-size: 20px;
            line-height: 24px;
            border-bottom: 1px solid #e5e6eb;
            padding-bottom: 5px;
        }

        .content {
            padding: 16px 0 24px;
            position: relative;
            color: gray;
            font-family: "PingFang SC";
            font-size: 18px;
            overflow: hidden;
            word-break: break-all;
            line-height: 22px;
        }

        p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="title"><?php echo $title ?></div>
        <p class="content"><?php echo $msg ?></p>
    </div>
</body>

</html>
<?php exit(); ?>