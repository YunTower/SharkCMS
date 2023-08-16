<?php
global $db;

$db = FrameWork::$_db;

function QueryCount($a)
{
    global $db;

    $key = FrameWork::getData();
    switch ($a) {
        case 'tag':
            echo count($db->table('sk_tag')->where("name = '$key'")->get());
            break;
        case 'category':
            echo count($db->table('sk_category')->where("name = '$key'")->get());
            break;
        default:
            FrameWork::Error(0, ['title' => '系统提示', 'msg' => '在调用模板方法时产生错误【View::count】，没有方法【' . $a . '】']);
            break;
    }
}

function Pager($pid, $all)
{
    if ($pid > $all) {
        header('Location:/');

    }
    $next_page = $pid + 1;
    $last_page = $pid - 1;
    if ($pid == 1) {
        $last_page == 1;
    }
    if ($pid == 1) {
        print  <<<EOT
        <div class="pagination flex items-center justify-between">
            <span class="text-sm">$pid / $all</span>
            <a class="btn w-20" role="navigation" href="/index/$next_page" title="下一页">
                下一页
            </a>
        </div>
        EOT;
    }
    else if ($pid == $all){
        print <<<EOT
<div class="pagination flex items-center justify-between">
<a class="btn w-20" role="navigation" href="/index/$last_page" title="上一页">
上一页
</a>
<span class="text-sm">$pid / $all</span>
</div>
EOT;


    }else {
        print <<<EOT
<div class="pagination flex items-center justify-between">
<a class="btn w-20" role="navigation" href="/index/$last_page" title="上一页">
上一页
</a>
<span class="text-sm">$pid / $all</span>
<a class="btn w-20" role="navigation" href="/index/$next_page" title="下一页">
下一页
</a>
</div>
EOT;
    }

}

