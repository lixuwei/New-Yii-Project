<?php
/**
 * 微博地址验证类
 * Author: rogee<rogeecn@gmail.com>
 * Date: 12-12-7
 * Time: 下午7:12
 * $Id: Weibo.php 20 2012-12-20 10:34:53Z rogeecn $
 */

class Weibo extends CValidator
{
    /**
     * http://weibo.com/xxx
     * http://t.qq.com/xxx
     */
    private $php_pattern = '/^http:\/\/.*?[weibo|qq].com\/.*/';

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
            $this->addError($object,$attribute,'不是正确的微博地址');
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

        return "if(".$condition.") {messages.push(".CJSON::encode('不是正确的微博地址').");}";
    }
}