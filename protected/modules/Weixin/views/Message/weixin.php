<?php
$text = <<<_TEXT_
<xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName>
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[this is a test]]></Content>
 <MsgId>1234567890123456</MsgId>
</xml>
_TEXT_;

echo CHtml::beginForm();
echo CHtml::textArea('w', $text, array('style'=>'width:100%;height:100px'));
echo CHtml::ajaxSubmitButton('POST', Yii::app()->createAbsoluteUrl('/Weixin/Message/Receiver'), array(
    'update' => '#tip',
));

echo CHtml::tag('div', array('id'=>'tip', 'style'=>'background:#f9f9f9;color:red;border:1px dashed pink; margin:20px 0;padding:20px;'), '信息提示区');
