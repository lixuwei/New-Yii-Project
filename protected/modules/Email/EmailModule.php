<?php

class EmailModule extends CWebModule
{
    public $defaultController = 'Mail';
    /* 定义服务器参数 */
    public $from = 'rogeecn@qq.com';
    public $sender = '益捐';
    public $protocol = 2;
    public $host = 'smtp.qq.com';
    public $port = 25;
    public $user = '';
    public $pass = '';


	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'Email.models.*',
			'Email.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
