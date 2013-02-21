<?php
    /**
     * 滚动BOX
     * @Author: Rogee<rogeecn@gmail.com>
     * Date: 12-12-17 下午1:36
     */

Yii::import('zii.widgets.CPortlet');
class Nano extends CPortlet
{
    public $contentCssClass = '';

    private $_openTag;
    private $_id;
    public function init()
    {
        //注册JS
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', true, -1, defined('YII_DEBUG'));
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jQuery');
        $cs->registerScriptFile($assetPrefix.'/jquery.nanoscroller.min.js', CClientScript::POS_END);
        $cs->registerCss('_NanoScrollBar'.$this->getId(), $this->_getStyleSheet() );
        $cs->registerScript('_NanoScrollBar'.$this->getId(), $this->_getJs() , CClientScript::POS_READY);

        ob_start();
        ob_implicit_flush(false);

        $this->_id = $this->getId();
        $this->htmlOptions['id']= $this->_id;
        $this->htmlOptions['class'] = 'nano';
        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        $this->renderDecoration();
        echo CHtml::openTag($this->tagName, array('class'=>'overthrow content description'))."\n";
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
        echo CHtml::closeTag($this->tagName);
    }

    private function _getJs()
    {
        $_js = <<<_JS_
      jQuery('.nano').nanoScroller({
        preventPageScrolling: true
      });
_JS_;
        return $_js;
    }

    private function _getStyleSheet()
    {
        $_css = <<<_CSS_
/** initial setup **/
.nano {
  position : relative;
  width    : 100%;
  height   : 100%;
  overflow : hidden;
}
.nano .content {
  position      : absolute;
  overflow      : scroll;
  overflow-x    : hidden;
  top           : 0;
  right         : 0;
  bottom        : 0;
  left          : 0;
}
.nano .content:focus {
  outline: thin dotted;
}
.nano .content::-webkit-scrollbar {
  visibility: hidden;
}
.has-scrollbar .content::-webkit-scrollbar {
  visibility: visible;
}
.nano > .pane {
  background : rgba(0,0,0,.25);
  position   : absolute;
  width      : 10px;
  right      : 0;
  top        : 0;
  bottom     : 0;
  visibility : hidden\9; /* Target only IE7 and IE8 with this hack */
  opacity    : .01;
  -webkit-transition    : .2s;
  -moz-transition       : .2s;
  -o-transition         : .2s;
  transition            : .2s;
  -moz-border-radius    : 5px;
  -webkit-border-radius : 5px;
  border-radius         : 5px;
}
.nano > .pane > .slider {
  background: #444;
  background: rgba(0,0,0,.5);
  position              : relative;
  margin                : 0 1px;
  -moz-border-radius    : 3px;
  -webkit-border-radius : 3px;
  border-radius         : 3px;
}
.nano:hover > .pane, .pane.active, .pane.flashed {
  visibility : visible\9; /* Target only IE7 and IE8 with this hack */
  opacity    : 0.99;
}
_CSS_;
        return $_css;
    }

}
?>