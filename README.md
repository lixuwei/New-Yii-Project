New-Yii-Project
===============
Yii新生成的项目直接复制一份，简单配置即可使用。

包含模块
------------------
* Rights Module
>RBAC权限控制器

* User
>用户注册管理

* Yii-debug-tool
>Yiiframework debug插件， 只在本地调试环境下开启。

个别自定义类使用
------------------
* components.Y
> 封装一些常用操作，直接静态调用即可使用

* components.Request
> onbeginRequest、onEndRequest 回调方法

* components.WebUser
> 继承自Right module 下的RWebUser组件， 用于对用户一些其它行为进行处理
