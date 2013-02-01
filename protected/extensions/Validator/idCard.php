<?php
/**
 * 身份证号正则验证
 * @Author Rogee<rogeecn@gmail.com>
 * Date: 12-12-6
 * Time: 下午2:57
 * $Id: idCard.php 612 2012-12-06 10:37:46Z rogeecn $
 */

class idCard extends CValidator
{
    private $php_pattern = '/(^\d{15}$)|(^\d{17}([0-9]|X|x)$)/';
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
            $this->addError($object,$attribute,'请输入15或18位身份证号码');
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
        $pattern = $this->php_pattern;//js的正则表达式验证
        $condition="!value.match({$pattern})";

        return "if(".$condition.") {messages.push(".CJSON::encode('请输入15或18位身份证号码').");}";
    }

}