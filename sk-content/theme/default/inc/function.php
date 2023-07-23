<?php
global $db;

$db = FrameWork::$_db;

function QueryCount($a)
{
    global $db;

    $key = FrameWork::getData();
    switch ($a) {
        case 'tag':
            echo $db->table('sk_tag')->where("name = '$key'")->count();
            break;
        case 'category':
            echo $db->table('sk_category')->where("name = '$key'")->count();
            break;
        default:
            FrameWork::Error('Error', '在调用模板方法时产生错误【View::count】，没有方法【' . $a . '】');
            break;
    }
}
