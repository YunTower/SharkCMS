<?php

use FrameWork\FrameWork;
use FrameWork\View\View;

?>
<div class="sidebar animated fadeInDown">
    <div class="logo-title">
        <div class="title">
            <img alt="Logo" class="inline-block" src="<?= View::vSet('name', 'd-home-avatar') ?>" style="width: 127px ;border-radius:50%" />
            <h3 class="!mt-3 !mb-0">
                <a href="<?= FrameWork::getDomain() ?>" title="<?= FrameWork::$getSetting['Site-Title'] ?>"><?= FrameWork::$getSetting['Site-Title'] ?></a>
            </h3>
            <div class="description mt-2">
                <p class="description-text"></p>
            </div>
        </div>
    </div>
    <ul class="social-links mt-1">

    </ul>

    <div class="footer">
        <a target="_blank" href="#">
            <a href="https://www.caicai.me">Designed by CaiCai</a>
            <div class="by_halo">
                <a href="https://www.sharkcms.cn" target="_blank">Powered by SharkCMS</a>

            </div>
            <div class="footer_text">
            </div>
        </a>
    </div>
</div>
