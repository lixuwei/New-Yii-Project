<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class WController extends CController
{
	public $layout='/layouts/main';
    public $messageType = 'text';

    public $developer = 'gh_cae07c9b6549';
    public $receiver = '';
    //设置回复信息方式
    public function setReply($Msg)
    {
        $this->receiver  = $Msg['from'];
        $this->log(json_encode($Msg));
    }
    //日志记录
    public function log($content)
    {
        $log = file_get_contents('wx.log');
        $log = $content."\n\r====================\n\r".$log;
        file_put_contents('wx.log', $log);
    }

    // 回复文本消息
    public function renderMsg($data) {
        $result = $this->render($this->messageType, array('data'=>$data), true);
        echo $result;
    }

}