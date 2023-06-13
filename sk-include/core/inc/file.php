<?php
class File
{

    public static function R_INI($file)
    {
        return parse_ini_file($file);
    }

    public static function W_INI($assoc_arr, $path, $has_sections = FALSE)
    {
        $content = "";
        if ($has_sections) {
            foreach ($assoc_arr as $key => $elem) {
                $content .= "[" . $key . "]\n";
                foreach ($elem as $key2 => $elem2) {
                    if (is_array($elem2)) {
                        for ($i = 0; $i < count($elem2); $i++) {
                            $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                        }
                    } else if ($elem2 == "") $content .= $key2 . " = \n";
                    else $content .= $key2 . " = \"" . $elem2 . "\"\n";
                }
            }
        } else {
            foreach ($assoc_arr as $key => $elem) {
                if (is_array($elem)) {
                    for ($i = 0; $i < count($elem); $i++) {
                        $content .= $key2 . "[] = \"" . $elem[$i] . "\"\n";
                    }
                } else if ($elem == "") $content .= $key2 . " = \n";
                else $content .= $key2 . " = \"" . $elem . "\"\n";
            }
        }
        if (!$handle = fopen($path, 'w')) {
            return false;
        }
        if (!fwrite($handle, $content)) {
            return false;
        }
        fclose($handle);
        return true;
    }

    public static function List($dir)
    {
        // 输出文件列表
        $handler = opendir($dir);
        while (($filename = readdir($handler)) !== false) { //务必使用!==，防止目录下出现类似文件名“0”等情况 
            if ($filename != "." && $filename != "..") {
                $files[] = $filename;
            }
        }
        closedir($handler);

        // 获取文件信息
        foreach ($files as $list){
            return (array('name'=>$list,'size'=>filesize($dir.'/'.$list),'time'=>date('Y-m-d H:i:s',filemtime($dir.'/'.$list))));
        }
        // return $files;
    }
}
