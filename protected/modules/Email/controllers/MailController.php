<?php
class MailController extends Controller
{
    public function actionIndex()
    {
        echo $this->module->from;
        var_dump($this->module);
    }
    /**
     * 用户找回密码功能 - 邮件发送
     */
    public function actionSend()
    {
        $user_conf = array(
            'mailto' => 'rogeecn@gmail.com',
            'subject' => '[重要] 益捐 用户密码重置邮件',
            'content' => 'this is a test email',
        );

        $config = $this->_getConf($user_conf);
        $ret = (new Mailer($config))->send();

        echo ($ret===true) ? 'Success' : 'Failed';
    }

    /**
     * 返回用户系统配置数组与用户数组合并后的数组
     * @param $conf 用户信息配置数组
     * @return array
     */
    private function _getConf($conf)
    {
        $module = $this->module;
        $sys_conf = array(
            'from'      => $module->from,
            'sender'    => $module->sender,
            'protocol'  => $module->protocol,
            'host'      => $module->host,
            'port'      => $module->port,
            'user'      => $module->user,
            'pass'      => $module->pass,
        );

        return array_merge($sys_conf, $conf);
    }
}