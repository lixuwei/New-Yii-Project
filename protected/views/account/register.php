<?php
$this->breadcrumbs=array(
    'Users'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List User', 'url'=>array('index')),
    array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
<div id="reg-form">
<h1>用户注册</h1>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'register-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row buttons">
        <?php
            echo CHtml::ajaxSubmitButton(
                    $model->isNewRecord ? 'Create' : 'Save',
                    '',
                    array(
                        'replace' => '#reg-form'
                    )
                );
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>