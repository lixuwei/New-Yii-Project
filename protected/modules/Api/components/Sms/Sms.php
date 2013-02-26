<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-25
 * Time: 下午2:45
 * To change this template use File | Settings | File Templates.
 */
class Sms
{
    const SMS_NUM = '101100-WEB-HUAX-386671';
    const SMS_PWD = 'QQZEMZIC';
    const SMS_CHILD_SIGNAL = '106900292321';

    const SMS_TYPE_STD_MSG = 'sms';

    private $_sms_info;
    private $_send_url;
    private $_send_param;

    private static $_model;
    public static function  model()
    {
        if( !(self::$_model instanceof Sms) ){
            self::$_model = new Sms();
        }
        return self::$_model;
    }
    /**
     * 立即发送
     * @param $phone
     * @param $content
     */
    public function sendTo($param, $type='sms')
    {
        $sms = $this->setInterfaceInfo($type);
        foreach($this->_send_param as $key => $value)
        {
            if( isset($param[$key]) )
            {
                //如果手机号是数组就成字符串
                if($key =='phone' && is_array($param['phone']))
                    $param['phone'] = implode(',', $param['phone']);

                //加密应该加密的东西
                if($key =='content' || $key == 'tim')
                    $param[$key] = $this->encode($param[$key]);

                $this->_send_param[$key] = $param[$key];
            }
            else
            {
                if(empty($this->_send_param[$key]))
                    throw new CHttpException('500', '缺少必要参数 -------> '.$key);
            }
        }
        $this->deal_param();
        return $this->doSend();
    }

    /**
     * 获取一个系统配置数组
     */
    private function getSysInfo()
    {
        return array(
            'reg' => self::SMS_NUM,
            'pwd' => self::SMS_PWD,
        );
    }
    /**
     * 处理发送参数问题
     */
    private function deal_param()
    {
        $param = array_merge($this->getSysInfo() ,$this->_send_param);
        $strParam = '';
        foreach($param as $key=>$value)
        {
            $strParam .=sprintf('&%s=%s', $key, $value);
        }

        $this->_send_param = trim($strParam, '&');
    }
    private function encode($content)
    {
        return rawurlencode($content);
    }

    private function doSend()
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->_send_url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$this->_send_param);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $this->_parse($data);
    }

    private function _parse($data)
    {
        if( $result['result'] != 0)
            return $result;
        else
            return true;

    }



    private function setInterfaceInfo($type)
    {
        $info = array(
            //注册接口
            'reg' => array(
                'http://www.stongnet.com/sdkhttp/reg.aspx',
                array(
                    'uname'=>'',
                    'mobile'=>'',
                    'phone'=>'',
                    'fax'=>'',
                    'email'=>'',
                    'postcode'=>'',
                    'company'=>'',
                    'address'=>'',
                )
            ),
            //查询余额
            'balance' => array(
                'http://www.stongnet.com/sdkhttp/getbalance.aspx',
                array()
            ),
            //发送短信
            'sms' => array(
                'http://www.stongnet.com/sdkhttp/sendsms.aspx',
                array(
                    'sourceadd' => self::SMS_CHILD_SIGNAL,
                    'phone' => '',
                    'content'=>'',
                ),
            ),
            //定时短信
            'sch_sms' => array(
                'http://www.stongnet.com/sdkhttp/sendschsms.aspx',
                array(
                    'sourceadd' => self::SMS_CHILD_SIGNAL,
                    'tim'=>'',//规定时间
                    'phone' => '',
                    'content' => '',
                ),
            ),
            //状态报告
            'status' => array(
                'http://www.stongnet.com/sdkhttp/getmtreport.aspx',
            ),
            //更新密码
            'refreshpwd' => array(
                'http://www.stongnet.com/sdkhttp/uptpwd.aspx',
                array(
                    'newpwd'
                ),
            )
        );

        $this->_send_url = $info[$type][0];
        $this->_send_param = $info[$type][1];
    }
}
