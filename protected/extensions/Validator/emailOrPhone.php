<?php
/**
 * 邮箱或者手机号验证
 * @Author Rogee<rogeecn@gmail.com>
 * Date: 12-12-6
 * Time: 下午2:57
 * $Id: emailOrPhone.php 621 2012-12-07 10:50:24Z rogeecn $
 */

class emailOrPhone extends CValidator
{
    private  $pattern_email = '/^([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,}([\.][a-z]{2,})*$/i';
    private  $pattern_phone = '/^0{0,1}(13[4-9]|15[7-9]|15[0-2]|18[0-8])[0-9]{8}$/';
    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object,$attribute)
    {
        $pattern_email = $this->pattern_email;
        $pattern_phone = $this->pattern_phone;
        // 把要验证的属性值从Model里取出来.
        $value=$object->$attribute;

        if(!( preg_match($pattern_email, $value) || preg_match($pattern_phone, $value) ) )//这里是正则验证啦
        {
            $this->addError($object,$attribute,'请输入合法的邮箱或手机号');
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
        $pattern_email = $this->pattern_email;
        $pattern_phone = $this->pattern_phone;

        $condition="!(value.match({$pattern_phone}) || value.match({$pattern_email}) )";

        return "if(".$condition.") {messages.push(".CJSON::encode('请输入合法的邮箱或手机号').");}";
    }

}