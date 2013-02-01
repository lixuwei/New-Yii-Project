<?php
/**
 * 登陆模块
 * Author: Rogee<rogeecn@gmail.com>
 * Date: 13-1-31
 * $Id$
 */

class AccountController extends Controller
{
    public $defaultAction = 'login';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights',
        );
    }


    /**
     * Actions that are always allowed.
     */
    public function allowedActions()
    {
        return '';
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    /**
     * user registration
     */
    public function actionRegister()
    {
        $model=new User;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save())
            {
                $this->renderPartial('_reg_ok');
                Y::end();
            }
        }

        $this->render('register',array(
            'model'=>$model,
        ));
    }

    /**
     * user findpassword
     */
    public function actionFindpwd()
    {
        $this->render('findpwd');
    }

    /**
     * user resetpasswd
     */
    public function actionResetpwd()
    {
        $this->render('resetpwd');
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        $form = array(
            'register-form',
        );
        if(isset($_POST['ajax']) && in_array( $_POST['ajax'], $form , true) )
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
