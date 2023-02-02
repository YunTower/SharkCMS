<?php
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
 deldir('../../sk-content/temp/log');
 deldir('../../sk-content/temp/download');
 $arr = array('msg' => '清理成功', 'status' => 'ok');
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;

