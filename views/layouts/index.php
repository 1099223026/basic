<?php
use yii\helpers\Html;
use app\assets\AppAsset;

// 加载js文件
AppAsset::register( $this );
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>点滴网</title>
    <?php echo Html::cssFile( 'assets/44a118f3/css/bootstrap.css' ); ?>
    <?php echo Html::cssFile( 'css/index.css' ); ?>
</head>
<body>
	
<?php $this->beginBody() ?>
<!-- 加载js文件 -->
<?php echo AppAsset::addPageScript( $this, '@web/js/refresh_ban_roll.js' ); ?>
<?php echo AppAsset::addPageScript( $this, '@web/js/index.js' ); ?>
<?php echo AppAsset::addPageScript( $this, '@web/assets/5ae5ac51/jquery.min.js' ); ?>
<?php echo AppAsset::addPageScript( $this, '@web/assets/44a118f3/js/bootstrap.js' ); ?>

<!--  页头  -->
<header class="l-header" style="background-image:url(../web/img/fj.jpeg);">
<div class="hdbg"></div>
<div class="hdbg2"></div>
<div class="m-about">
    <div id="logo">

		<a href="#"><img src="../web/img/npz.gif"></a>		
	</div>
    	<h1 class="tit"><a href="#">Web开发奶瓶仔的博客</a></h1>
        <div class="about">世上最痛苦的事之一，不是落单，而是身边有一圈人，让你感觉自己孤身一人。</div>

</div>
</header>
<!--  导航栏  -->
    <nav>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
<!--                    手机端导航栏-->
                    <div class="navbar-header text-center">
                        <span class="glyphicon glyphicon-th-list"></span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<!--  内容  -->
    <section>
        <div class="container">
            <div class="row">
                <?php echo $content ?>
                <!--窗口小部件-->
                <aside class="col-md-4">
                	<!--搜索框-->
                    <div class="widget mgnb-35">
                        <h4 class="widget-title">搜索</h4>
                        <?php $form = \yii\bootstrap\ActiveForm::begin([
                            'action' => ['site/search'],
                            'method'=>'get',
                            'options' => ['class' => 'pst-relative'],
                        ]); ?>
                            <?= $form->field($this->params[ 'model' ], 'content')->textInput([
                                'style' => "border-radius: 0;width: 185px;",
                                'class'=> "form-control",
                                'placeholder'=>'请输入要查找的文章',
                                'name' => 'content'
                            ])->label( false ); ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', [
                                'class'=>'btn',
                                'style' =>'position: absolute;top: 0;left: 190px;border-radius: 0;color:#fff;background: #e67e22;'
                            ]) ?>
                        <?php \yii\bootstrap\ActiveForm::end(); ?>
                    </div>
                    <!--社区-->
                    <div class="widget mgnb-35">
                        <h4 class="widget-title">相关链接</h4>
                        <div>
                            <p class="mgnb-clear">
                                <a class="widget-leave" href="index.php?r=site/index">
                                    <span class="glyphicon glyphicon-home"></span>
                                    &nbsp;首页
                                </a>
                            </p>
                            <p class="mgnb-clear">
                                <a target="_blank" class="widget-leave" href="index.php?r=message-board/index">
                                    <span class="glyphicon glyphicon-file"></span>
                                    &nbsp;留言
                                </a>
                            </p>
                            <p class="mgnb-clear">
                                <a class="widget-leave" href="index.php?r=report/index">
                                	<span class="glyphicon glyphicon-tree-deciduous"></span>
                                	&nbsp;查看寝室消费
                                </a>
                            </p>
                            <p class="mgnb-clear">
                                <a class="widget-leave" target="_blank" href="http://think.cmf.com/admin">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    &nbsp;后台管理
                                </a>
                            </p>
                        </div>
                    </div>
                    <!--文章精选-->
                    <div class="widget mgnb-35">
                        <h4 class="widget-title">文章精选</h4>
                        <?php foreach ( $this->params[ 'artCulling' ] as $cull ){?>
                            <div class="row">
                                <p class="col-md-6 text-out-hidden mgnb-clear"  data-toggle="tooltip" data-placement="left" title="<?= $cull[ 'post_title' ]?>">
                                <!--标题隐藏超出部分-->
                                    <a class="text-title" href="index.php?r=site/find-article-by-id&id=<?=$cull['id']?>">
                                        <?= $cull[ 'post_title' ]?>
                                    </a>
                                </p>
                                <div class="col-md-6 text-date"><?= $cull[ 'post_date' ]?></div>
                            </div>
                        <?php }?>
                    </div>
                    <!--标签云-->
                    <div class="widget mgnb-35">
                        <h4 class="widget-title">标签云</h4>
                        <div class="content tag-cloud">
                            <?php foreach ( $this->params[ 'terms' ] as $term ){?>
                        	<a href="index.php?r=site/show-article-by-tab&tab=<?=$term['name'];?>"><?php echo $term['name'];?></a>
                            <?php }?>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
<!--  页脚  -->
    <footer class="footer-bottom">
        <div class="container">
            <div class="row">
                <!--最新文章-->
                <div class="col-md-4">
                    <div class="footer-widget mgnb-35">
                        <h4 class="title">最新文章</h4>
                        <div class="recent-scrap">
                            <?php foreach ( $this->params[ 'newArt'] as $art ){?>
                                <a class="recent-scrap-title" href="index.php?r=site/find-article-by-id&id=<?=$art['id']?>"><?php echo $art['post_title'];?></a>
                                <div class="recent-scrap-date"><?php echo $art['post_date'];?></div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <!--友情链接-->
                <div class="col-md-4">
                    <div class="footer-widget mgnb-35">
                        <h4 class="title">友情链接</h4>
                        <div class="friendly-link">
                            <a class="friendly-link-title" href="http://www.yii-china.com" target="_blank">Yii2.0中文网</a>
                        </div>
                        <div class="friendly-link">
                            <a class="friendly-link-title" href="http://www.bootcss.com" target="_blank">Bootstrap中文网</a>
                        </div>
                        <div class="friendly-link">
                            <a class="friendly-link-title" href="http://www.jquery123.com" target="_blank">JQuery API 中文文档</a>
                        </div>
                    </div>
                </div>
                <!--我们用到的技术-->
                <div class="col-md-4">
                    <div class="footer-widget mgnb-35">
                        <h4 class="title">我们用到的技术</h4>
                        <div class="use-skill">
                            <a class="use-skill-title" href="javascript:void(0);">Yii2.0</a>
                            <a class="use-skill-title" href="javascript:void(0);">Bootstrap</a>
                            <a class="use-skill-title" href="javascript:void(0);">JQuery</a>
                            <a class="use-skill-title" href="javascript:void(0);">JSON</a>
                            <a class="use-skill-title" href="javascript:void(0);">Ajax</a>
                            <a class="use-skill-title" href="javascript:void(0);">HTML5</a>
                            <a class="use-skill-title" href="javascript:void(0);">CSS3</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<!--  copyright  -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">Copyright © 消费系统官网 | 渝ICP备16005727号 | 渝ICP备16005727号-1</div>
            </div>
        </div>
    </div>
<!--  回到顶部  -->
    <a href="#" id="back-to-top" class="inline go-to-top hidden">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>