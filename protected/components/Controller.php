<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /**
     * 调用JSON
     * @param bool $status
     * @param string $msg
     * @param string $info
     * @param bool $exit
     */
    public function renderJSON($status=true, $msg='', $info='', $exit = true)
    {
        $data = array(
            'status' => $status,
            'msg'    => $msg,
            'info'   => $info
        );

        $data = CJSON::encode($data);
        $this->render('//system/_json', array('data'=>$data));
        if($exit) Y::end();
    }

    /**
     * @param $name
     * @param array $except
     * @return mixed
     */
    public function encodePost( $name, $except = array() )
    {
        $_post = $_POST[$name];

        foreach ($_post as $key => &$value)
        {
            if ( !empty($except) && in_array($key, $except) ) continue;

            $value = CHtml::encode($value);
        }

        return $_post;
    }
}