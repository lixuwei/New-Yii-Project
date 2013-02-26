<?php
/**
 * 短信网关通信API
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-2-25
 * $Id$
 */
Yii::import('Api.components.Sms.Sms');
class SmsController extends Controller
{
    public function actionSendVerify()
    {
        $this->renderJSON(true, '信息发送成功!');
        $phone = Yii::app()->request->getParam('phone');
        $content = Yii::app()->request->getParam('content');

        if(empty($phone))
            $this->renderJSON(false, '手机号码不可以为空');

        $phone_pattern = '/^0{0,1}(13[4-9]|15[7-9]|15[0-2]|18[0-8])[0-9]{8}$/';
        if(!preg_match($phone_pattern, $phone))
            $this->renderJSON(false, '手机号码不合法');

        $smsParam = array(
            'phone' => trim($phone),
            'content' => $this->_getVerifyContent(),
        );
        $sms = Sms::model()->sendTo($smsParam);
        if($sms !== true)
            $this->renderJSON(false, '短信发送失败!');

        $this->renderJSON(true, '信息发送成功!');
    }

    private function _getVerifyContent()
    {
        return '您的短信验证码为:'.time().', 请妥善保管';
    }
    public function actionIndex()
    {
        $this->render('index');
    }
}
