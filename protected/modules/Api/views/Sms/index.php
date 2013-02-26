<?php
echo CHtml::beginForm();
echo CHtml::textField('phone','18601013734');
echo "<br />";
//echo CHtml::textField('content', '你好北京');
echo "<br />";
echo CHtml::ajaxSubmitButton('点击发送', Yii::app()->createAbsoluteUrl('/Api/Sms/SendVerify'), array(
    'beforeSend' => 'js:function(jqXHR, setting){jQuery("#ajax_submit_button").val("发送中...");}',
    'success' =>'js:function(data, text, XHR){jQuery("#tip").html(data.msg);jQuery("#ajax_submit_button").val("发送完成");}',
), array(
    'id' => 'ajax_submit_button'
));
echo CHtml::endForm();
echo CHtml::tag('div', array('id'=>'tip', 'style'=>'background:#f9f9f9;color:red;border:1px dashed pink; margin:20px 0;padding:20px;'), '信息提示区');
