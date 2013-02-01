<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YiiProjectTemplete',
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Shanghai',
    'defaultController'=>'site',

	// preloading 'log' component
	'preload'=>array('log'),

    // request 回调
    'onBeginRequest' => array( 'Request', 'onBeginRequest'),
    'onEndRequest'   => array( 'Request', 'onEndRequest'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',

        /* for ext yii-rights */
        'application.modules.rights.*',
        'application.modules.rights.components.*',

        /* for ext yii-debug */
        'application.extensions.YiiDebug.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			'ipFilters'=>array('127.0.0.1','::1'),
		),

        'rights'=>array(
            'debug'=>true,
            'enableBizRuleData'=>true,
        ),
	),

	'components'=>array(
		'user' => array(
            'class'=>'WebUser',
			'allowAutoLogin'=>true,
            'loginUrl' => array('Account/login'),
		),

        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),

        'request'=>array(
            'enableCsrfValidation'=>true,
        ),

        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'tb_authitem',
            'itemChildTable'=>'tb_authitemchild',
            'assignmentTable'=>'tb_authassignment',
            'rightsTable'=>'tb_rights',
            'defaultRoles' => array('Authenticated', 'Guest'),
        ),

        'urlManager' => include( dirname(__FILE__).'/url.conf.php' ),

        'db' => include( dirname(__FILE__).'/db.conf.php' ),

		'log' => array(
                'class'=>'CLogRouter',
                'routes'=>include( dirname(__FILE__).'/log.conf.php'),
            ),
    ),

	'params'=>include( dirname(__FILE__).'/params.conf.php' ),
);