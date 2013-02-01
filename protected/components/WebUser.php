<?php
/**
 * 用户管理
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-1-31
 * $Id$
 */

class WebUser extends RWebUser
{
    public function checkUser($type = 0)
    {
        return Yii::app()->user->getState('user_type') == $type;
    }
}
