<?php
namespace app\controllers;

use yii\data\Pagination;
/**
 * Class TraitController
 * @package app\controllers
 * @author 向国平
 * @explain 控制器的公共操作
 */
trait TraitController
{
    /**
     * @param $query sql查询结果
     * @param $field 排序字段 默认为date 降序排序
     * @return array  pages=>分页对象 model=>获取到consume表数据
     */
    public static function paging( $query, $field = 'date', $pageSize='12' )
    {
        // 传入记录总数 and 一页显示记录数
        $pages = new Pagination([ 'totalCount' => $query->count(), 'pageSize' => $pageSize ]);
        $model = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->orderBy($field.' DESC')
            ->all();
        return ['pages' => $pages, 'model' => $model];
    }

    /************************************************************************/
    /**
     * @explain 过滤arrObjToArr函数执行后的null值（内部函数）
     * @param $data 传入一个二维数组
     * @return mixed
     */
    public static function filterNull( $data )
    {
        $ilen = count( $data );
        for ( $i = 0; $i < $ilen; $i++ ){
            $jlen = count( $data[ $i ] );
            for ( $j = 0; $j < $jlen; $j++ ){
                // 接收过滤后的值
                $data[ $i ][ $j ] = array_filter( $data[ $i ][ $j ] );
            }
        }
        return $data;
    }
    /**
     * @explain 将数组对象转换为数组（内部函数）和objectToarray一起使用
     * @param $data 三维数组 进入两层，然后把第三层交给对象转数组
     * @return $data 数组
     */
    public static function arrObjToArr( $data )
    {
        $ilen = count( $data );
        for ( $i = 0; $i < $ilen; $i++ ){
            $jlen = count( $data[ $i ] );
            for ( $j = 0; $j < $jlen; $j++ ){
                $data[ $i ][ $j ] = TraitController::objectTOarray( $data[ $i ][ $j ] );
            }
        }
        return $data;
    }
    /**************************以上两个配合使用（objectToarray是公共的）**************************/

    /**
     * @explain 对象转换为数组(内部函数)
     * @param $object 具体对象，不是数组对象
     * @return $array 返回数组形式
     */
    public static function objectToarray($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }

    /************************************************************************/
    /**
     * @explain 过滤arrObjToArr函数执行后的null值（内部函数）
     * @param $data 传入一个二维数组
     * @return mixed
     */
    public static function filterNullTwo( $data )
    {
        $ilen = count( $data );
        for ( $i = 0; $i < $ilen; $i++ ){
            // 接收过滤后的值
            $data = array_filter( $data );
        }
        return $data;
    }
    /**
     * @explain 将数组对象转换为数组（内部函数）和objectToarray一起使用
     * @param $data 二维数组
     * @return $data
     */
    public static function arrObjToArrTwo( $data )
    {
        $ilen = count( $data );
        for ( $i = 0; $i < $ilen; $i++ ){
            $data[ $i ] = TraitController::objectTOarray( $data[ $i ] );
        }
        return $data;
    }
    /**************************以上两个配合使用（objectToarray是公共的）**************************/

}