<?php
/**
 * 1001 未登录
 * 1002 未使用SNS登录
 * 1003 未授权的AUTH登陆方式
 *
 * 2001 用户权限不中
 *
 * 3001 SNS服务器错误
 * 4001 系统错误
 */
class SnsController extends Controller
{
	public function actionIndex()
	{
		$this->render('share');
	}

    /**
     * 登陆跳转
     * @param string $type
     */
    public function actionLogin($Type='QQ')
    {
        $auth_arr = array('QQ', 'Weibo');
        if( in_array(trim($Type), $auth_arr) )
        {
            //请空登陆时已经存在的TOKEN
            Yii::app()->user->setState('token', null);
            $auth_class = trim($Type).'Connect';
            $auth = new $auth_class();
            $auth->Login();
        }else{
            throw new CHttpException('404', '未授权的登录方式', '1003');
        }
    }

    /**
     * 回调工作
     * @param string $type
     */
    public function actionCallback($Type="QQ")
    {
        $isSuccess = false;
        if( $Type == 'Weibo')
        {
            $wb = new WeiboConnect();
            $isSuccess = $wb->Callback();
        }else{
            $qc = new QQConnect();
            $qc->Callback();
            $qc->get_openid();
            $isSuccess = true;
        }

        if( $isSuccess )
            $this->redirect(array('/site/index'));
    }

    public function actionShare()
    {
        /*
        if( !$this->_isLogin() )
            $this->renderJSON(false,'对不起,请先登录', 1001);
*/
        if( !$this->_isSnsLogin() )
            $this->renderJSON(false, '请登录您的SNS账号进行绑定', 1002);

        //开始发送微博
        $content = Yii::app()->request->getParam('sns_content');
        if( true !== ( $share_info = $this->_sendSnsShare($content) ) )
            $this->renderJSON(false, $share_info, 3001);

        $this->renderJSON(true, '发送成功', '');
    }


    /**
     * 系统判定后返回发送消息状态
     * @return bool|string 成功返回true,失败返回SNS失败信息
     */
    private function _sendSnsShare($content)
    {
        $AuthType = $this->_getAuthType().'Connect';
        $auth = new $AuthType;
        $ret = $auth->sendTextMSG($content);

        return $ret;
    }

    /**
     * 返回当前登录的类型信息
     * @return string
     */
    private function _getAuthType(){
        return Yii::app()->user->getState('SNS_TYPE');
    }

    /**
     * 判定用户是否是登录用户
     * @return mixed
     */
    private function _isLogin()
    {
        return !Yii::app()->user->isGuest;
    }

    /**
     * 判定是否是SNS用户登录, 如非需要跳转授权登录
     * @return bool
     */
    private function _isSnsLogin()
    {
        $user = Yii::app()->user->getState('isSnsUser');
        return ($user===true);
    }
}