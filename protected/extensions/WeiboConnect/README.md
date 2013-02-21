# Weibo互联 Version 1.0

* Author: Rogee
* Email: Rogeecn@Gmail.Com
* Blog: http://www.qoophp.com


## 安装步骤
* 必须放置于extensions目录下
* 在 `config/main.php` 中修改以下代码

```php
	'import'=>array(
		...
        'ext.WeiboConnect.WeiboConnect',//添加自动调用QQ登录
        ...
	),
```

## 示例代码
```php
    //登陆跳转
    public function actionLoginWeibo()
    {
        $weibo = new WeiboConnect();
        $weibo->Login();
    }

    //登录回调
    public function actionWeiboConnnectCallBack()
    {
        $weibo = new WeiboConnect();
        echo $qc->Callback();//已经自动存入SESSION
    }
```