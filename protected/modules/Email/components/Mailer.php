<?php
/**
 * Description of Mail
 *
 * @author syang
 */
//注意，这里我们要使用一个第三方类库phpmailer，所以我们先将class.phpmailer.php放到vendors下，
//并通过import将路径加入到include_path中，
Yii::import('Email.components.phpmailer.*');
//引用class.phpmailer.php，由于第三方类库可能不符合yii的加载规则，把以需要手动加载。
require_once 'class.phpmailer.php';

class Mailer {
    const MAIL_PROTOCOL_LOCAL = 1;
    const MAIL_CHARSET = 'UTF-8';

    private $timeout    = 30;
    private $priority   = 3; // [1]High, [3]Normal, [5]Low
    private $charset = 'UTF-8';
    private $is_html = true;
    private $port = 25;
    private $debug      = false;

    private $mailer;

    function __construct($config)
    {
        $this->mailer = new phpmailer();

        $this->mailer->From     = $config['from'];
        $this->mailer->FromName = $this->_base64_encode($config['sender']);

        if ($config['protocol'] == MAIL_PROTOCOL_LOCAL)
            $this->mailer->IsMail();
        else
        {
            /* smtp发送设置 */
            $this->mailer->IsSMTP();
            $this->mailer->Host     = $config['host'];
            $this->mailer->Port     = $config['port'];
            $this->mailer->SMTPAuth = !empty($config['pass']);
            $this->mailer->Username = $config['user'];
            $this->mailer->Password = $config['pass'];
        }

        //配置一些发送选项
        $this->mailer->Priority     = !isset($config['priority']) ? $this->priority : $config['priority'];
        $this->mailer->CharSet      = !isset($config['charset']) ? $this->charset : $config['charset'];

        $is_html = !isset($config['is_html']) ? $this->is_html : $config['is_html'];
        $this->mailer->IsHTML($config['is_html']);

        $this->mailer->Timeout      = !isset($config['timeout']) ? $this->timeout : $config['timeout'];
        $this->mailer->SMTPDebug    = !isset($config['debug']) ? $this->debug :$config['debug'];

        //设置收件人选项
        $this->mailer->Subject      = $this->_base64_encode($config['subject']);
        $this->mailer->Body         = $config['content'];
        $this->mailer->ClearAddresses();
        $this->mailer->AddAddress($config['mailto']);
    }

    public function send()
    {
        $res = $this->mailer->Send();
        if (!$res)
        {
            if( $this->debug )
                return $this->mailer->ErrorInfo;
            else
                return false;
        }
        return $res;
    }

/*    function send($mailto, $subject, $content, $charset='utf-8', $is_html=true, $receipt = false)
    {
        $this->mailer->Priority     = $this->priority;
        $this->mailer->CharSet      = $charset;
        $this->mailer->IsHTML($is_html);
        $this->mailer->Subject      = $this->_base64_encode($subject);
        $this->mailer->Body         = $content;
        $this->mailer->Timeout      = $this->timeout;
        $this->mailer->SMTPDebug    = $this->debug;
        $this->mailer->ClearAddresses();
        $this->mailer->AddAddress($mailto);

        $res = $this->mailer->Send();
        if (!$res)
        {
            $this->errors[] = $this->mailer->ErrorInfo;
        }
        return $res;
    }*/

    function _base64_encode($str = '')
    {
        return '=?' . self::MAIL_CHARSET . '?B?' . base64_encode($str) . '?=';
    }
}