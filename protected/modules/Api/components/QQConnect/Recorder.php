<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();

        //-------读取配置文件
        $incFileContents = file_get_contents(dirname(__FILE__)."/inc.php");
        $this->inc = json_decode($incFileContents);
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        $session = Yii::app()->user->getState('token');
        if(empty($session)){
            self::$data = array();
        }else{
            self::$data = $session;//$_SESSION['QC_userData'];
        }
    }

    public function write($name,$value){
        if($name == 'access_token')
        {
            Yii::app()->user->setState('isSnsUser', true);
            Yii::app()->user->setState('SNS_TYPE', 'QQ');
        }
        self::$data[$name] = $value;
        Yii::app()->user->setState('token', self::$data);
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
        Yii::app()->user->setState('token', self::$data);
    }

    function __destruct(){
        //$_SESSION['QC_userData'] = self::$data;
    }
}
