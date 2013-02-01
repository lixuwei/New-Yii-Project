<?php
/**
 * 手机或电话正则验证
 * @Author Rogee<rogeecn@gmail.com>
 * Date: 12-12-6
 * Time: 下午2:57
 * $Id: phone.php 611 2012-12-06 10:31:39Z rogeecn $
 */

class phone extends CValidator
{
    /**
     * 设置验证类型, mobile, telphone, both
     */
    public $type = 'mobile';

    private $pattern;

    private $pattern_mobile = '/^1[3|4|5|8][0-9]\d{8}$/';
    private $pattern_tel	= '/^\d{3,4}-\d{7,8}(-\d{3,4})?$/';
    private $pattern_both   = '/(^1[3|4|5|8][0-9]\d{8}$)|(^\d{3,4}-\d{7,8}(-\d{3,4})?$)/';
    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object,$attribute)
    {
        $this->setPattern();
        // 把要验证的属性值从Model里取出来.
        $value=$object->$attribute;

        if(!preg_match($this->pattern, $value))//这里是正则验证啦
        {
            $this->addError($object,$attribute,'不合法的手机或固定电话');
        }
    }

    /**
     * Returns the JavaScript needed for performing client-side validation.
     * @param CModel $object the data object being validated
     * @param string $attribute the name of the attribute to be validated.
     * @return string the client-side validation script.
     * @see CActiveForm::enableClientValidation
     */
    public function clientValidateAttribute($object,$attribute)
    {
        $this->setPattern();
        $condition="!value.match({$this->pattern})";

        return "if(".$condition.") {messages.push(".CJSON::encode('不合法的手机或固定电话').");}";
    }

    private function setPattern()
    {
        switch ($this->type)
        {
            case 'telphone':
                $pattern = $this->pattern_tel;
                break;
            case 'both':
                $pattern = $this->pattern_both;
                break;
            default:
                $pattern = $this->pattern_mobile;
                break;
        }
        $this->pattern = $pattern;
    }


}