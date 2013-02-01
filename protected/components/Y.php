<?php
/**
 * Yii框架便捷处理类
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-1-31
 * $Id$
 */

class Y
{
    public static function url($url='')
    {
        return Yii::app()->createUrl($url);
    }

    public static function end()
    {
        Yii::app()->end();
    }

    public static function cs()
    {
        return Yii::app()->getClientScript();
    }

    public static function access( $operation, $params=array(), $allowCaching=true)
    {
        return Yii::app()->user->checkAccess($operation, $params, $allowCaching);
    }

    public static function isGuest()
    {
        return Yii::app()->user->isGuest;
    }
}
