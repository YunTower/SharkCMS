<?php
// 系统信息
$app_v = App_V;
$app_t = App_T;
$domain = sys_domain();
$time = time();
// 更新版本
$url = file_get_contents("https://api.sharkcms.cn/update/$app_t/check.php?t=$app_t&v=$app_v&d=$domain&t=$time&m=php");
$json = json_decode($url, true);
if ($json['install'] == 'no') {
    $arr = array('msg' => $json['msg'], 'status' => '');
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $json;
} else {
    $new = $json['new'];
    // 下载更新包
    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    // 此更新包是专为更新定制的，无法直接下载使用，只能用于系统更新
    file_put_contents("./sk-content/temp/download/$new.zip", file_get_contents("https://api.sharkcms.cn/file/update/$app_t/$new.zip", false, stream_context_create($arrContextOptions)));
    // 解压更新包
    $zip = new ZipArchive;
    if ($zip->open("./sk-content/temp/download/$new.zip") === true) {
        $zip->extractTo("./");
        $zip->close();
        $arr = array('msg' => '更新成功！', 'status' => 'ok');
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $json;
    } else {
        $arr = array('msg' => '更新失败！', 'status' => '');
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $json;
    }
}
