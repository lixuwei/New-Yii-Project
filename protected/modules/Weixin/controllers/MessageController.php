<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-25
 * Time: 下午6:14
 * To change this template use File | Settings | File Templates.
 */
class MessageController extends WController
{
    public function actionReceiver()
    {
        $Obj = WeChartReceiver::model()->run();
        $msg_info = $Obj->getMsg();
        $this->setReply($msg_info);

        //获取消息解析
        $renderInfo = $this->_ParseMsg($msg_info);
        $renderInfo = array(
            'type'=>'music',
            'data'=>array(
                'title' => '你的温柔',
                'desc' => 'wq i tdutr fbfy',
                'normal_url' => 'http://www.sina.com/a.mp3',
                'hq_url' => 'http://www.sina.com/a.mp3',
            )
        );
        $this->messageType = $renderInfo['type'];
        $data = $renderInfo['data'];
        $this->renderMsg($data);
    }

    private function _ParseMsg($msg)
    {
        $parser = new WxParser($msg);
        return $parser->run();
    }

    public function actionTester()
    {
        $this->layout = '//layouts/column1';
        $this->render('weixin');
    }
    public function actionGetImg()
    {
        $img = file_get_contents('http://mmsns.qpic.cn/mmsns/0icZOCNIcaibCqZQXnfia3ticn1z5bCrv1x7mtnCc33cVziawKiaYVDpAaibg/0');
        file_put_contents('a.jpg', $img);
    }
}
