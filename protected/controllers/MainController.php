<?php

class MainController extends Controller
{
    //I N D E X
    public function actionIndex()
    {
        //redirect to ERP module
        $this->render('welcome');
    }

    //L O G  O U T
    public function actionLogout()
    {
        //delete user info from session
        Yii::app()->user->logout();
        $this->redirect('/main/login');
    }

    //L O G  I N
    public function actionLogin()
    {

        //set titles
        $this->page_title = 'Login';
        $this->site_title = 'Olivia ERP';

        //redefine layout
        $this->layout = '//layouts/login_layout';

        //if logged in - redirect to index
        if(!Yii::app()->user->isGuest){$this->redirect($this->createUrl('main/index'));}

        //if post request
        if(Yii::app()->request->isPostRequest)
        {
            //create validation from-model object
            $validation=new LoginForm();

            //set all parameters from post
            $validation->attributes = $_POST;

            // validate user input and redirect to the previous page if valid
            if($validation->validate() && $validation->login())
            {
                $this->redirect(Yii::app()->createUrl('main/index'));
            }

            // render form and errors
            $this->render('login',array('errors'=>$validation->getErrors()));
        }
        else
        {
            //render form
            $this->render('login',array('errors'=>array()));
        }
    }


    /**
     * Ajax action go change status of different objects
     * @param $model_class string Class of model to get from base object
     * @param $id  int id of object
     * @param $status int Status value
     */

    public function actionChangeStatus($model_class,$id,$status)
    {
        /* @var $model_class CActiveRecord */
        /* @var $object ProductCards */

        //if this is ajax
//        if(Yii::app()->request->isAjaxRequest)
//        {
            //try find
            $object = $model_class::model()->findByPk($id);

            //if found
            if($object)
            {
                //set status
                $object->setAttribute('status',$status);

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
//        }

    }
}