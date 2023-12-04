<?php

function Pager($pid, $all)
{
    if (!$all) {
        echo '<div class="post-page">
        <div class="post animated fadeInDown">
            <div id="post-content" class="post-content markdown-body"><p>暂无数据</p></div></div></div>';
    } else {
        if ($pid > $all) {

            header('Location:/');
        }

        $next_page = $pid + 1;
        $last_page = $pid - 1;
        if ($pid == 1) {
            $last_page == 1;
        }
        if ($pid == 1) {
            if ($all == 1) {
                print  <<<EOT
                <div class="pagination flex items-center justify-between">
                    <span class="text-sm">$pid / $all</span>
                </div>
                EOT;
            } else {
                print  <<<EOT
            <div class="pagination flex items-center justify-between">
                <span class="text-sm">$pid / $all</span>
                <a class="btn w-20" role="navigation" href="/index/$next_page" title="下一页">
                     下一页
                 </a>
            </div>
            EOT;
            }
        } else if ($pid == $all) {
            print <<<EOT
            <div class="pagination flex items-center justify-between">
                <a class="btn w-20" role="navigation" href="/index/$last_page" title="上一页">
                    上一页
                </a>
                <span class="text-sm">$pid / $all</span>
            </div>
            EOT;
        } else {
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
}
