<?php
/**
 * 滚动BOX
 * @Author: Rogee<rogeecn@gmail.com>
 * Date: 12-12-17 下午1:36
 */

Yii::import('zii.widgets.CPortlet');
class scrollBox extends CPortlet
{
    public $height = '300';
    private $_javascript;

    private $_openTag;
    private $_id;
    public function init()
    {
        //注册JS
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', true, -1, defined('YII_DEBUG'));
        $cs = Yii::app()->clientScript;
        $cs->registerScritpFile
        $cs->registerScriptFile($assetPrefix.'/jquery.mousewheel.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($assetPrefix.'/jquery.mCustomScrollbar.min.js', CClientScript::POS_END);
        $cs->registerCssFile($assetPrefix.'/mCustomScrollbar.css');

        ob_start();
        ob_implicit_flush(false);

        $this->_id = $this->getId();
        $this->htmlOptions['id']= $this->_id;
        $this->htmlOptions['class'] = 'scroll';
        $this->htmlOptions['style'] = 'height: '.$this->height.';overflow-y:hidden;';
        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        $this->renderDecoration();
        $this->_openTag=ob_get_contents();
        ob_clean();
    }

    public function run()
    {
        $this->renderContent();
        $content=ob_get_clean();
        echo $this->_openTag;
        echo $content;
        echo CHtml::closeTag($this->tagName);

        $_js = 'if(jQuery(".scroll").length > 0){ jQuery(".scroll").mCustomScrollbar();}';
        Yii::app()->clientScript->registerScript('scroll'.$this->getId(), $_js,CClientScript::POS_READY);
    }
}
?>
