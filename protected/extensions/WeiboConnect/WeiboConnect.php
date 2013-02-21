<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-2-20
 * Time: 下午6:06
 * To change this template use File | Settings | File Templates.
 */
define(WB_AKEY, '3520234935');
define(WB_SKEY, 'ec4213886cd7157f6a182b8ef9401093');
define(WB_CALLBACK_URL, Yii::app()->createAbsoluteUrl('site/WeiboConnectCallback'));

Yii::import('ext.WeiboConnect.SaeTOAuthV2');
Yii::import('ext.WeiboConnect.OAuthException');
Yii::import('ext.WeiboConnect.SaeTClientV2');
class WeiboConnect
{
    private static $_auth;
    private static $_token;

    public static $_client;

    public function __construct()
    {
        self::$_auth = new SaeTOAuthV2( WB_AKEY, WB_SKEY );
    }

    /**
     * weibo login redirect
     */
    public function Login()
    {
        $code_url = self::$_auth->getAuthorizeURL( WB_CALLBACK_URL );
        header('Location:'.$code_url);
    }

    /**
     * callback
     */
    public function Callback()
    {
        $o = self::$_auth;

        if ( isset($_REQUEST['code']) )
        {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $o->getAccessToken( 'code', $keys );
            } catch (OAuthException $e) {
            }
        }

        if ($token)
        {
            //$_SESSION['token'] = $token;
            Yii::app()->user->setState('token', $token);
            self::$_token = $token;
            setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
            self::$_client = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['token']['access_token'] );
        }
    }

    /**
     * 模拟一个OPENID出来
     */
    public function getOpenId()
    {
        return self::$_token['uid'];
    }

    /**
     * 得出一个有效endline
     */
    public function getEndLine()
    {
        $endline = time() + self::$_token['expires_in'];
        return $endline;
    }
}
