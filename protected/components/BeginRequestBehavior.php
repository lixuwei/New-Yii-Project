<?php
/**
 * request回调类
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-2-1
 * $Id$
 */
class BeginRequestBehavior extends CBehavior
{
    public function attach($owner)
    {
        $owner->attachEventHandler('onBeginRequest', array($this, 'onBeginRequest') );
        //此处可添加多个回调
    }

    public function onBeginRequest()
    {
    }
}