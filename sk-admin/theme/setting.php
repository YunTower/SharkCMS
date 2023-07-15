<style>
    a {
        text-decoration: none;
    }

    .row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .col {
        overflow: hidden;
        /* padding: 15px; */
    }

    .col .card {
        width: 100%;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .col img {
        width: 100%;
        height: auto;
        border: 0;
    }

    .col .card-body {
        padding: 0 15px 15px 15px;
        background-color: #fff;
    }

    .card-body h5 {
        font-size: 24px;
        margin: 7px 0;
    }


    .card p {
        color: #6c757d;
    }

    .card-body .date-author span {
        color: #e74c3c;
    }

    .card-body .date-author a {
        color: #e74c3c;
    }

    .card-body h5 a {
        color: #222;
    }

    .tag {
        background-color: #e74c3c;
        color: white;
        z-index: 999;
        position: absolute;
        border-bottom-right-radius: 5px;
        border-top-left-radius: 5px;
        padding: 3px;
    }


    img {
        z-index: 888;
    }

    .card-body {
        border-radius: 5px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;


    }

    .col:hover {
        border: 2px solid #2d8cf0;
        border-top-left-radius: 6px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .useing {
        border: 2px solid #1cc88a;
        border-top-left-radius: 6px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .useing:hover {
        border: 2px solid #1cc88a;

    }

    .card-text a {
        color: #2d8cf0;

    }
</style>
<div class="sk-theme">
    <div class="layui-row layui-col-space15">
        <?php
        foreach (View::ThemeConfig() as $key => $value) :
            $file = CON . 'theme/' . $key . '/preview.png';
            if (!file_exists($file)) {
                echo '<blockquote class="layui-elem-quote layui-quote-nm sk-blockquote-warn">在加载主题【' . $value['app']['Name'] . '】的预览图片【' . $file . '】时产生错误：文件不存在，它可能不是一个有效的主题</blockquote>';
            } else {
                $cover = FrameWork::getDomain() . '/sk-content/theme/' . $key . '/preview.png';
            }

        ?>
            <div class="layui-col-md3">
                <div class="row">
                    <div class="col <?php if ($value['use']){echo 'useing';} ?>">
                        <div class="card">
                            <div class="tag">官方</div>
                            <img src="<?php echo $cover ?>" alt="" />
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href=""><?php echo $value['app']['Name'] ?></a>
                                    <div class="set">
                                        <?php
                                        if ($value['use']) {
                                            echo '<span class="layui-badge layui-bg-green">使用中</span>';
                                        } else {
                                            echo '<span class="layui-badge">启用</span>';
                                        } ?>
                                        <span class="layui-badge-rim">设置</span>
                                    </div>
                                </h5>
                                <p class="date-author">
                                    <span class="author">By <a href="<?php echo $value['app']['Author Url'] ?>"><?php echo $value['app']['Author'] ?></a></span>
                                </p>
                                <p class="card-text">
                                    <?php echo $value['app']['Description'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>