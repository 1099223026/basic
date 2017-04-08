<?php

namespace app\controllers;

use app\models\ArticleTerm;
use Yii;
use yii\coreseek\SphinxClient;
use yii\web\Controller;
use app\models\Posts;
use app\models\TermRelationships;
use yii\data\Pagination;
/**
 * 类用途：
 * 1、切换前台页面（主页）
 * 2、传递参数设置导航栏的border-bottom
 * 3、给主页传数据
 */
class SiteController extends Controller
{
    public function actionTest(){
        $sphinx = new SphinxClient();
        $sphinx->SetServer( '123.206.81.240', 9312 );
        $sphinx->SetMatchMode( SPH_MATCH_ANY );
//        var_dump( $sphinx );

        $index="test1";
        $res = $sphinx->Query( '北京天津上海', $index);
        $err = $sphinx->GetLastError();
        var_dump( $res );
    }
    /* 前台页面 */
    // 主页
    public function actionIndex()
    {
        //运行存储过程函数
        $cmd = Yii::$app->db->createCommand( "call p_replace_article_mesh" );
        $cmd->execute(); // 此处尚未判断返回值
        // 用源生的sql分页摸不着头脑
        // 获取文章列表(数据库中是一个视图)
        // 并且进行分页
        $query = ArticleTerm::find();
        $data = TraitController::paging( $query, 'post_date', '4' );
        $model = $data['model'];
        $pages = $data['pages'];
        // 取出smeta的图片地址进行重新写入
        $model = ArticleTerm::setSmeta( $model );
        $model = Posts::updateYearMonPatt( $model );
        // 获取最新文章、文章精选、标签数据;并将结果保存到view内
        $newArt = $artCulling = $terms = null;
        TraitController::getPageInitData( $newArt, $artCulling, $terms);
        // 设置布局文件
        $this->layout = 'index';
        return $this->render( 'home',array(
            'article' => $model,
            'page' => $pages,
        ) );
    }

    // 显示具体文章内容
    public function actionArticleContent( $id ){
        $article = ArticleTerm::findArtById( $id );
        // 对查询到的图片地址进行重写
        $article = ArticleTerm::setSmeta( $article );
        // 对日期格式重写
        $article = Posts::updateYearMonPatt( $article );
        // 获取最新文章、文章精选、标签数据;并将结果保存到view内
        $newArt = $artCulling = $terms = null;
        TraitController::getPageInitData( $newArt, $artCulling, $terms);
        // 指定布局文件
        $this->layout = 'index';
        return $this->render( 'article', array(
            'article' => $article,
        ));
    }
}
