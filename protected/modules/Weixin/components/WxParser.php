<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-25
 * Time: 下午8:02
 * To change this template use File | Settings | File Templates.
 */
class WxParser
{
    private $_MSG;
    public function __construct($msg)
    {
        $this->_MSG = $msg;
    }

    public function run()
    {
        return '';
    }
}
