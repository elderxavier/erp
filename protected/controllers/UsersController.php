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
     * Returns array of all possible rights which can be edited. These settings used in 'edit' and 'create' templates
     * @return array
     */
    public function GetRightsSettings()
    {
        $arr = array(
            $this->labels['product cards'] => array(
                array('name' => $this->labels['delete'], 'right' => 'products_delete'),
                array('name' => $this->labels['edit'], 'right' => 'products_edit'),
                array('name' => $this->labels['create'], 'right' => 'products_add'),
                array('name' => $this->labels['see'], 'right' => 'products_see')
            ),
            $this->labels['product categories'] => array(
                array('name' => $this->labels['delete'], 'right' => 'categories_delete'),
                array('name' => $this->labels['edit'], 'right' => 'categories_edit'),
                array('name' => $this->labels['create'], 'right' => 'categories_add'),
                array('name' => $this->labels['see'], 'right' => 'categories_see')
            ),
            $this->labels['clients'] => array(
                array('name' => $this->labels['delete'], 'right' => 'clients_delete'),
                array('name' => $this->labels['edit'], 'right' => 'clients_edit'),
                array('name' => $this->labels['create'], 'right' => 'clients_add'),
                array('name' => $this->labels['see'], 'right' => 'clients_see')
            ),
            $this->labels['suppliers'] => array(
                array('name' => $this->labels['delete'], 'right' => 'suppliers_delete'),
                array('name' => $this->labels['edit'], 'right' => 'suppliers_edit'),
                array('name' => $this->labels['create'], 'right' => 'suppliers_add'),
                array('name' => $this->labels['see'], 'right' => 'suppliers_see')
            ),
            $this->labels['purchases'] => array(
                array('name' => $this->labels['create'], 'right' => 'purchases_add'),
                array('name' => $this->labels['see'],  'right' => 'purchases_see')
            )
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


    /**
     * Create new user
     */
    public function actionAdd()
    {
        //get all positions as array of pairs
        $positions = Positions::model()->getAllAsArray();
        //array of possible roles
        $roles = array(0 => $this->labels['regular user'], 1 => $this->labels['root']);

        //create form-validator and model
        $form = new UserForm();

        //if got post from form
        if($_POST['UserForm'])
        {
            //set attributes to form model and user
            $form->attributes = $_POST['UserForm'];

            //if validation passed
            if($form->validate() && $form->validateFile('UserForm','avatar'))
            {
                //new user
                $user = new Users();

                //get attributes
                $user->attributes = $_POST['UserForm'];

                //password must be in md5
                $user->password = md5($user->password);

                //set dates
                $user->date_changed = time();
                $user->date_created = time();

                //who modified
                $user->user_modified_by = Yii::app()->user->id;


                //if have avatar
                if($form->file_size > 0)
                {
                    //new filename
                    $new_filename = $this->generateRandomString().'.'.$form->file_extension;

                    //if file copied
                    if(copy($form->file_temp_name, 'images/user_thumbs/'.$new_filename))
                    {
                        //set new avatar
                        $user->avatar = $new_filename;
                    }
                }


                //save user
                $user->save();

                //get rights array
                $rights_from_checkboxes = $_POST['UserForm']['rights'];

                //set user rights
                $this->UserSetRights($rights_from_checkboxes,$user->id);

                //redirect to list
                $this->redirect('/'.$this->id.'/list');
            }
        }

        //render
        $this->render('user_create', array('form_mdl' => $form, 'positions' => $positions, 'roles' => $roles));
    }


    /**
     * Edit user
     * @param null $id
     * @throws CHttpException
     */
    public function actionEdit($id = null)
    {
        /* @var $user Users */

        //new user
        $user = Users::model()->findByPk($id);

        //if found
        if(!empty($user))
        {
            //get rights of user
            $rights = $this->UserGetRights($user->id);

            //get all positions as array of pairs
            $positions = Positions::model()->getAllAsArray();
            //array of possible roles
            $roles = array(0 => $this->labels['regular user'], 1 => $this->labels['root']);

            //create form-validator and model
            $form = new UserForm();

            //set current user id to form-validator, to avoid unique-check-error when updating
            $form->current_user_id = $user->id;

            //if got post from form
            if($_POST['UserForm'])
            {
                //old avatar
                $old_ava = $user->avatar;

                //set attributes to form model and user
                $form->attributes = $_POST['UserForm'];
                $user->attributes = $_POST['UserForm'];

                //if validation passed
                if($form->validate() && $form->validateFile('UserForm','avatar'))
                {
                    //set dates
                    $user->date_changed = time();

                    //who modified
                    $user->user_modified_by = Yii::app()->user->id;

                    //if have avatar
                    if($form->file_size > 0)
                    {
                        //new filename
                        $new_filename = $this->generateRandomString().'.'.$form->file_extension;

                        //if file copied
                        if(copy($form->file_temp_name, 'images/user_thumbs/'.$new_filename))
                        {
                            //delete old avatar if exist
                            if($old_ava != '' && file_exists('images/user_thumbs/'.$old_ava))
                            {
                                unlink('images/user_thumbs/'.$old_ava);
                            }

                            //set new avatar
                            $user->avatar = $new_filename;
                        }
                    }

                    //save user
                    $user->update();

                    //get rights array
                    $rights_from_checkboxes = $_POST['UserForm']['rights'];

                    //set user rights
                    $this->UserSetRights($rights_from_checkboxes,$user->id);

                    //redirect to list
                    $this->redirect('/'.$this->id.'/list');
                }
            }



            //render
            $this->render('user_edit', array('form_mdl' => $form, 'user' => $user, 'positions' => $positions, 'roles' => $roles, 'rights' => $rights));
        }
        //if user not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }

    }

    /**
     * Delete user
     * @param null $id
     * @throws CHttpException
     */
    public function actionDelete($id = null)
    {
        /* @var $user Users */

        //new user
        $user = Users::model()->with('operationsSrvs')->findByPk($id);

        //if user found
        if($user)
        {
            //if found usages in other tables
            if(count($user->operationsSrvs) > 0)
            {
                //render restrict message
                $this->render('restricts');
            }
            //if no usages
            else
            {
                //delete all right-relations
                UserRights::model()->deleteAllByAttributes(array('user_id' => $user->id));

                //if user avatar not empty and file exist
                if($user->avatar != '' && file_exists('images/user_thumbs/'.$user->avatar))
                {
                    //delete avatar file
                    unlink('images/user_thumbs/'.$user->avatar);
                }


                //delete user
                $user->delete();

                //redirect to list
                $this->redirect('/'.$this->id.'/list');
            }
        }
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }


    /**
     * Returns array of rights for user
     * @param $user_id int id of user
     * @return array
     */
    public function UserGetRights($user_id)
    {
        /* @var $user Users */
        /* @var $user_right UserRights */
        /* @var $right Rights */

        //get user
        $user = Users::model()->with('userRights')->findByPk($user_id);

        //array of rights
        $rights = array();

        //create array of rights
        foreach($user->userRights as $user_right)
        {
            $right = Rights::model()->findByPk($user_right->rights_id);
            $rights[$right->label] = 1;
        }

        return $rights;
    }

    /**
     * Creates right relations with user in database
     * @param $rights_array mixed array of rights from checkboxes
     * @param $user_id int id of existing user
     */
    public function UserSetRights($rights_array,$user_id)
    {
        //delete all rights related with this user (clean all rights)
        UserRights::model()->deleteAllByAttributes(array('user_id' => $user_id));

        //pass through each right in array
        foreach($rights_array as $right_label => $state)
        {
            /* @var $right Rights */

            //get right by it's name
            $right = Rights::model()->findByAttributes(array('label' => $right_label));

            //if right found
            if(!empty($right))
            {
                /* @var $user_right_relation UserRights */

                //create new user-right relation record
                $user_right_relation = new UserRights();

                //set user id
                $user_right_relation -> user_id = $user_id;

                //set right id
                $user_right_relation -> rights_id = $right->id;

                //set value (useless, this field should be deleted)
                $user_right_relation -> right_value = 1;

                //save
                $user_right_relation -> save();
            }
        }
    }

}