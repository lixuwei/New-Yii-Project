<?php
/**
 * Flot 图表插件
 * @Author: Rogee<rogeecn@gmail.com>
 * Date: 13-1-9 下午7:07
 * $Id$
 */
class Flot extends CWidget
{
    public $style;
    public $htmlOptions;

    private $_id;
    public function init()
    {
        $this->_id = $this->getId();
        //注册JS
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', true, -1, defined('YII_DEBUG'));
        $cs = Yii::app()->clientScript;
        $scripts = array('stack', 'pie', 'resize');
        $cs->registerScriptFile($assetPrefix.'/jquery.flot.js');
        foreach ($scripts as $v) {
            $cs->registerScriptFile($assetPrefix.'/jquery.flot.'.$v.'.js');
        }

        Yii::app()->clientScript->registerScript($this->_id, $this->_getJs(), CClientScript::POS_END );

        $this->htmlOptions['id'] = $this->_id;
        $this->htmlOptions['style'] = $this->style;
    }

    public function run()
    {
        //CHtml::tag('div', $this->htmlOptions,false, true);
        echo "<div style=\"padding-top: 20px;\">";
        echo "  <div style=\"$this->style\" id=\"$this->_id\"></div>";
        echo '</div>';

    }

    private function _getJs()
    {
        $js = <<<SCRIPT
var sin1 = [], sin2 = [], cos1 = [], cos2 = [];

        for (var i = 0; i < 14; i += 0.3) {
            sin1.push([i, Math.sin(i)]);
            sin2.push([i, Math.sin(i-1.57)]);
            cos1.push([i, Math.cos(i)]);
            cos2.push([i, Math.cos(i+1.57)]);
        }

        jQuery.plot(jQuery("#{$this->_id}"), [ { data: sin1, label: "sin(x)"}, { data: sin2, label: "sin(y)"} ,
        { data: cos1,
        label: "cos(x)"}, { data: cos2, label: "cos(y)"} ], {
                series: {lines: { show: true }, points: { show: true }},
                grid: { hoverable: true, clickable: true },
                yaxis: { min: -1.1, max: 1.1 }
                });
SCRIPT;

        return $js;
    }


}

