<!DOCTYPE html>
<?php
if ($_GET['url']==null){
    ob_clean();
    sys_error('系统错误','无效请求！');
    exit;
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>外链跳转</title>
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
            font-size: 18px;
            line-height: 24px;
        }

        .link {
            padding: 16px 0 24px;
            border-bottom: 1px solid #e5e6eb;
            position: relative;
            color: gray;
            font-family: "PingFang SC";
            font-size: 14px;
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

        .go {
            float: right;
            margin-bottom: 24px;
            margin-top: 20px;
            color: #fff;
            border-radius: 3px;
            border: none;
            background: #007fff;
            height: 32px;
            font-size: 14px;
            padding: 0 14px;
            cursor: pointer;
            outline: 0;
        }
    </style>
</head>

<body>
    <div class="main">
        <?php $url = $_GET['url']; ?>
        <div class="title">即将离开本站，请注意个人信息安全</div>
        <p class="link"><?php echo $url; ?></p>
        <button class="go">继续访问</button>
    </div>
    <script>
        $('.go').click(function() {window.location.href="<?php echo $url; ?>"})
    </script>
</body>

</html>