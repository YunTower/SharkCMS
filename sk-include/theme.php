<?php
function theme_menu($list)
{
    $menu_1 = "首页";
    $menu_2 = "关于";

    if ($list == '1') {
        return $menu_1;
    } else if ($list == '2') {
        return $menu_2;
    }
}

function theme_site_title()
{
    return "SharkCMS";
}

function theme_site_logo($file_name)
{
    
    return  '../sk-content/upload/'.$file_name;
}

