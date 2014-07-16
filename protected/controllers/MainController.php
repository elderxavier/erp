<?php

class MainController extends Controller
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        //render welcome screen
        $this->render('welcome');
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        //delete user info from session
        Yii::app()->user->logout();
        $this->redirect('/main/login');
    }

    /**
     * Login
     */
    public function actionLogin()
    {

        //set titles
        $this->page_title = 'Login';
        $this->site_title = 'Olivia ERP';

        //redefine layout
        $this->layout = '//layouts/login_layout';

        //if logged in - redirect to index
        if(!Yii::app()->user->isGuest){$this->redirect($this->createUrl('main/index'));}

        //create validation from-model object
        $validation=new LoginForm();

        //if post request
        if($_POST['LoginForm'])
        {
            //set all parameters from post
            $validation->attributes = $_POST['LoginForm'];

            // validate user input and redirect to the previous page if valid
            if($validation->validate() && $validation->login())
            {
                $this->redirect('index');
            }
        }

        $this->render('login',array('model'=>$validation));
    }


    /**
     * Changes status of object by ajax
     * @param null $id
     */
    public function actionChangeProductStatus($id = null)
    {
        //if this is ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //try find
            $object =  ProductCards::model()->findByPk($id);

            //if found
            if($object)
            {
                if($object->status == 1){
                    $object->status = 0;
                }else{
                    $object->status = 1;
                }
                //update
                $object->update();

                //out success message
                exit('SUCCESS');
            }
            //if not found
            else
            {
                //out fail message
                exit('FAILED');
            }
        }
    }
}