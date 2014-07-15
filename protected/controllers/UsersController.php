<?php

class UsersController extends Controller
{
    /**
     * Returns sub-menu settings
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'users' => array('action' => 'list','visible' => $this->rights['users_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add user' => array('action' => 'add', 'visible' => $this->rights['users_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        //do listing
        $this->actionList();
    }

    /**
     *List
     */
    public function actionList()
    {
        //users - empty array
        $users = array();

        //if current user - root
        if(Yii::app()->user->GetState('role') == 1)
        {
            //get all users
            $users = Users::model()->findAll();
        }
        //if current user not root
        else
        {
            //ignore root-users
            $users = Users::model()->findAllByAttributes(array('role' => 0));
        }

        //render list
        $this->render('user_list', array('users' => $users));
    }


    public function actionAdd()
    {
        //get all positions as array of pairs
        $positions = Positions::getAllAsArray();
        $roles = array(0 => $this->labels['regular user'], 1 => $this->labels['root']);

        //create form-validator and model
        $form = new UserForm();
        $user = new Users();

        $this->render('user_create', array('form_mdl' => $form, 'user' => $user, 'positions' => $positions, 'roles' => $roles));
    }
}