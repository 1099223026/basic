<!--主页-->
<!--卡片集-->
<main class="col-md-8">
    <!--卡片-->
<?php foreach ($article as $art ){ ?>
    <article class="card bg-white">
        <header class="text-center">
            <!--标题-->
            <h1 class="card-title mgn-clear"><a href="#"><?=$art['post_title'];?></a></h1>
            <!--作者、时间-->
            <div class="mgnt-15">作者：<span class="cl-brown">奶瓶仔</span> • <time class="card-date"><?=$art['post_date'];?></time></div>
        </header>
        <!--精选图片-->
        <section class="featured-img mgnt-35 text-center">
            <img class="hgt-wdt-percent" src="<?=$art['smeta']?>">
        </section>
        <!--内容-->
        <section class="card-content mgnt-35">
            <?=$art['post_excerpt'];?>
            <!--查看全部按钮-->
            <div class="mgnt-35 card-btn text-left">
                <a class="submit-art" href="http://basic.yii2.com/yii2/basic/web/index.php?r=site/article-content&id=<?php echo( $art['id'] );?>">
                    <button id="card-btn" type="button" class="btn bg-brown">查看全部</button>
                </a>
            </div>
        </section>
        <!--底部-->
        <footer class="card-footer text-left">
            <span class="glyphicon glyphicon-folder-open"></span>
            &nbsp;&nbsp;<?php
//            将name变量分割成没有逗号的数组
                    $arr = explode( ',', $art[ 'name' ] );
//            循环打印出数组
                    foreach ( $arr as $tag ) {
               ?>
                    <a class="tag-link-title" href="#"><?php echo $tag;?></a>
                <?php }?>
        </footer>
    </article>
<?php }?>
    <div class="pull-right">
        <?php
        echo \yii\widgets\LinkPager::widget([
             'pagination' => $page
        ]);
        ?>
    </div>
</main>
