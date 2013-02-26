<?php
class MailController extends Controller
{
    const MAIL_USER = '15402586';
    const MAIL_PWD  = 'adminhao888123';

    /**
     * 用户找回密码功能 - 邮件发送
     */
    public function actionSend()
    {
        $email = 'rogeecn@gmail.com';
        $message = 'this is a test email';

        $config = array(
            'from' => 'rogeecn@qq.com',
            'sender'	=> '益捐',
            'protocol' => '2',
            'host' => 'smtp.qq.com',
            'prot' => 25,
            'user' => self::MAIL_USER,
            'pass' => self::MAIL_PWD,

            'mailto' => $email,
            'subject' => '[重要] 益捐 用户密码重置邮件',
            'content' => 'for the test...',
        );
        $ret = (new Mailer($config))->send();
        CVarDumper::dump($ret);

        if( $ret === true){
            echo '<a>已经发送成功</a>';
        }else{
            echo '<a>发送失败!</a>';
        }
    }
}