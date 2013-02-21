# QQ互联 Version 2.0

* Author: Rogee
* Email: Rogeecn@Gmail.Com
* Blog: http://www.qoophp.com


## 安装步骤
* 必须放置于extensions目录下
* 在 `config/main.php` 中修改以下代码
```php
	'import'=>array(
		...
        'ext.QQConnect.QQConnect',//添加自动调用QQ登录
        ...
	),
```

## 示例代码
```php
    //登陆跳转
    public function actionLoginQQ()
    {
        $qq = new QQConnect();
        $qq->qq_login();
    }

    //登录回调
    public function actionQQConnnectCallBack()
    {
        $qc = new QQConnect();
        echo $qc->qq_callback();//已经自动存入SESSION
        echo '<hr />';
        echo $qc->get_openid();

    }
```