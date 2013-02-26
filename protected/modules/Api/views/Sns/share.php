<h1>SNS Share</h1>
<?php
    echo CHtml::beginForm();
    echo CHtml::textArea('sns_content', '这是一条测试分享的内容...'.date("Y/m/d H:i:s", time() ), array('style'=>'width:100%;height:80px;') );

    echo CHtml::ajaxSubmitButton('发布', Yii::app()->createAbsoluteUrl('/Api/Sns/Share'), array(
        'success'=>'js:function(data, text, XHR){ $("#tip").html(data.msg); }',
    ), array('style'=>'width:100%;height:80px') );
    echo CHtml::endForm();

    echo CHtml::tag('div', array('id'=>'tip', 'style'=>'background:#f9f9f9;color:red;border:1px dashed pink; margin:20px 0;padding:20px;'), '信息提示区');
?>
