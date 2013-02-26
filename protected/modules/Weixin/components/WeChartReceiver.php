<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-25
 * Time: 下午6:38
 * To change this template use File | Settings | File Templates.
 */
class WeChartReceiver
{
    private $_msg;
    private $_info_array;

    private static $_model;
    public static function model(){
        if (!isset(self::$_model)) {
            $c = __CLASS__;
            self::$_model = new $c;
        }

        return self::$_model;
    }


    public function run()
    {
        if(isset($_POST['w']) && !empty($_POST['w']) )
            $postStr = $_POST['w'];
        else
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr))
        {
            $this->_msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            file_put_contents('xx.log', $postStr);
            return $this;
        }else{
            exit;
        }
    }

    /**
     * 获取消息的数组应用
     * @return array
     */
    public function getMsg()
    {
        if ( !is_array($this->_info_array) ){
            $this->_info_array = array(
                'to' => $this->_msg->ToUserName,
                'from' => $this->_msg->FromUserName,
                'text' => $this->_msg->Content,
                'msgid' => $this->_msg->MesgId,
                'pic'   => $this->_msg->PicUrl,
                'location' => array(
                        'pos'=>array(
                                $this->_msg->Location_X,
                                $this->_msg->Location_Y,
                        ),
                        'label' => $this->_msg->Label,
                        'scale' => $this->_msg->Scale
                    ),
                'time' => $this->_msg->CreateTime,
            );
        }
        return $this->_info_array;
    }
}
