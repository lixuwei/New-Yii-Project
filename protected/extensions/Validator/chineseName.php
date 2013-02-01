<?php
/**
 * 中文名正则验证
 * @Author Rogee<rogeecn@gmail.com>
 * Date: 12-12-6
 * Time: 下午2:57
 * $Id: chineseName.php 619 2012-12-07 10:08:09Z wangheshang $
 */

class chineseName extends CValidator
{
    private $php_pattern = '/^[\x{4e00}-\x{9fa5}]{2,}$/u';
    private $js_pattern  = '/^[\u4e00-\u9fa5]{2,}$/';

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object,$attribute)
    {
        $pattern = $this->php_pattern;//PHP的正则验证
        // 把要验证的属性值从Model里取出来.
        $value=$object->$attribute;

        if(!preg_match($pattern, $value))//这里是正则验证啦
        {
            $this->addError($object,$attribute,'请输入中文姓名');
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
        $pattern = $this->js_pattern;//js的正则表达式验证
        $condition="!value.match({$pattern})";

        return "if(".$condition.") {messages.push(".CJSON::encode('请输入中文姓名').");}";
    }

}