<?php

namespace app\controllers;

use app\models\ArticleTerm;
use app\models\Terms;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
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
        // 获取最新文章
        $newArt = Posts::getNewArticle();
        // 对最新文章日期的格式重写
        $newArt = Posts::updateYearMonPatt( $newArt );
        // 获取标签数据
        $terms = Terms::find()
            ->select("name")
            ->all();
        // 将标签、最新文章...传递到布局文件中
        $view = Yii::$app->view;
        $view->params[ 'newArt' ] = $newArt;
        $view->params[ 'terms' ] = $terms;
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
        // 获取最新文章
        $newArt = Posts::getNewArticle();
        // 对最新文章日期的格式重写
        $newArt = Posts::updateYearMonPatt( $newArt );
        // 获取标签数据
        $terms = Terms::find()
            ->select("name")
            ->all();
        // 将标签、最新文章...传递到布局文件中
        $view = Yii::$app->view;
        $view->params[ 'newArt' ] = $newArt;
        $view->params[ 'terms' ] = $terms;
//        var_dump($article);exit;
        // 指定布局文件
        $this->layout = 'index';
        return $this->render( 'article', array(
            'article' => $article,
        ));
    }
}
