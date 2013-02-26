<?php
class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){

        //-------读取配置文件
        $incFileContents = file_get_contents(dirname(__FILE__)."/inc.php");
        $this->inc = json_decode($incFileContents);
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        $session = Yii::app()->user->getState('QC_userData');
        if(empty($session)){
            self::$data = array();
        }else{
            self::$data = $session;//$_SESSION['QC_userData'];
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
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
    }

    function __destruct(){
        //$_SESSION['QC_userData'] = self::$data;
        Yii::app()->user->setState('QC_userData', self::$data);
    }
}
