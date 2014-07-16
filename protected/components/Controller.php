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
    public $messages = array();

    //array of rights of current user
    public $rights = array();

    //default titles of site pages
    public $site_title = "ERP";
    public $page_title = "default";

    /**
     * Initialization of controller
     */
    public function init(){

        $this->labels = Labels::model()->getLabels();
        $this->messages = FormMessages::model()->getLabels();
    }


    /**
     * Generates random string (used for file-name generation and e.g.)
     * @param int $length
     * @param bool $uppercase
     * @return string
     */
    public function generateRandomString($length = 8, $uppercase = false)
    {
        //string of chars
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        //count of chars
        $numChars = strlen($chars);
        //empty string
        $string = '';
        //collect random chars from char-string
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        //returns string (can be in uppercase if uppercase set to true)
        return $uppercase ? strtoupper($string) : $string;
    }

    /**
     * Performs before every action
     * @param CAction $action
     * @return bool
     */
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

    /**
     * Constructor override
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        //get rights from session
        $this->rights = Yii::app()->user->GetState('rights');

        //call parent constructor
        parent::__construct($id, $module);
    }
}