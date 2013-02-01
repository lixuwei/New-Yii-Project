<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <?php echo CHtml::encode(Yii::app()->name); ?></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>
    <?php
        var_dump(Yii::app()->params['adminEmail']);
        echo Yii::app()->user->id;
    echo md5('4567demo');
    ?>
</p>