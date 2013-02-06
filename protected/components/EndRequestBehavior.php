<?php
/**
 * 结束请求调用
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-2-6
 * $Id$
 */

class EndRequestBehavior extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onEndRequest', array($this, 'onEndRequest') );
        //此处可添加多个回调
    }

    public function onEndRequest()
    {
    }
}
