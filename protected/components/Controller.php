<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main_layout';
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

    //array of labels for forms
    public $labels = array();

    //array of rights of current user
    public $rights = array();

    //default titles of site pages
    public $site_title = "ERP";
    public $page_title = "default";
    
    public function init(){

        $this->labels = Labels::model()->getLabels();
    }

    //returns user rights
    public static function GetUserRights()
    {
        /* @var $user_rights UserRights */
        $user_rights = Yii::app()->user->GetState('rights');
        return $user_rights;
    }

    //do before every action
    protected function beforeAction($action) {

        //if current action - not login
        if (Yii::app()->controller->action->id!=='login')
        {
            //if user not logged in
            if (Yii::app()->user->isGuest)
            {
                //redirect to login
                $this->redirect($this->createUrl('//main/login'));
            }
        }

        return parent::beforeAction($action);
    }

    //override constructor
    public function __construct($id,$module=null)
    {

        //get rights from session
        $this->rights = Yii::app()->user->GetState('rights');

        //call parent constructor
        parent::__construct($id, $module);
    }
}