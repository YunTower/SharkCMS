<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php Theme::SiteTitle() ?></title>
    <? Theme::import('header.php'); ?>
</head>

<body>
    <?
    Theme::import('home_left.php');
    Theme::import('home_nav.php');
    Theme::import('home_right.php');
    Theme::import('footer.php'); 
    ?>
</body>

</html>