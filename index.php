<?php
$yii=dirname(__FILE__).'/../yiiframework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.conf.php';


if( $_SERVER['HTTP_HOST'] == 'localhost')
    defined('YII_DEBUG') or define('YII_DEBUG',true);
else
    defined('YII_DEBUG') or define('YII_DEBUG',false);


defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
require_once($yii);
Yii::createWebApplication($config)->run();
