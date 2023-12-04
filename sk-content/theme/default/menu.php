<div class="page-top animated fadeInDown">
    <div id="nav" class="nav ml-[30px] mr-4 flex h-full flex-1 flex-nowrap items-center gap-6 overflow-x-auto whitespace-nowrap text-sm">
        <div class="nav-item relative inline-flex h-full items-center text-black/70 transition-all hover:text-[#4786D6]">
            <a href="/">首页</a>
        </div>
        <div class="nav-item relative inline-flex h-full items-center text-black/70 transition-all hover:text-[#4786D6]">
            <a href="/categories/default">默认分类</a>
        </div>
        <div class="nav-item relative inline-flex h-full items-center text-black/70 transition-all hover:text-[#4786D6]">
            <a href="/tags/halo">Halo</a>
        </div>
        <div class="nav-item relative inline-flex h-full items-center text-black/70 transition-all hover:text-[#4786D6]">
            <a href="/about">关于</a>
        </div>
    </div>
    <div class="information gap-4">
        <div class="flex  cursor-pointer items-center justify-center rounded-full text-gray-500 transition-all ">
            <a>
                <?php
                use FrameWork\User\User;
                if (User::$loginStatus) {
                    echo '<a class="link" href="/admin/user" target="_blank">' . User::$userInfo['name'] . '</a>';
                } else {
                    echo '<a class="link" href="/admin/login" target="_blank">未登录</a>';
                }
                ?>
            </a>
        </div>
    </div>
</div>