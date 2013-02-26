<h1>Vote</h1>
<?php
echo CHtml::beginForm();
$url = Yii::app()->createAbsoluteUrl('/Api/Vote/Vote');
echo CHtml::hiddenField('Vote[sid]', 1);
echo CHtml::hiddenField('Vote[pid]', 1);
echo CHtml::hiddenField('Vote[type]', 'count');

echo CHtml::ajaxSubmitButton('Vote +1', $url, array(
    'success'=>'js:function(data, text, XHR){ $("#tip").html(data.msg); }',
), array('style'=>'width:100%;height:80px') );
echo CHtml::endForm();

echo CHtml::tag('div', array('id'=>'tip', 'style'=>'background:#f9f9f9;color:red;border:1px dashed pink; margin:20px 0;padding:20px;'), '信息提示区');
?>