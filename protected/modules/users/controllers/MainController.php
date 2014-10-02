<?php

class MainController extends Controller
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
            ),
            $this->labels['sales'] => array(
                array('name' => $this->labels['create'], 'right' => 'sales_add'),
                array('name' => $this->labels['see'], 'right' => 'sales_see')
            ),
            $this->labels['services'] => array(
                array('name' => $this->labels['delete'], 'right' => 'services_delete'),
                array('name' => $this->labels['edit'], 'right' => 'services_edit'),
                array('name' => $this->labels['create'], 'right' => 'services_add'),
                array('name' => $this->labels['see'], 'right' => 'services_see')
            ),
            $this->labels['users'] => array(
                array('name' => $this->labels['delete'], 'right' => 'users_delete'),
                array('name' => $this->labels['edit'], 'right' => 'users_edit'),
                array('name' => $this->labels['create'], 'right' => 'users_add'),
                array('name' => $this->labels['see'], 'right' => 'users_see')
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
    public function actionList($page = 1, $on_page = 3)
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

        //arrays for select-boxes
        $positions = Positions::model()->getAllAsArray();
        $cities = UserCities::model()->findAllAsArray();

        //pagination object (contains all items on page)
        $pager = new CPagerComponent($users,$on_page,$page);

        //render list
        $this->render('user_list', array('pager' => $pager, 'positions' => $positions, 'cities' => $cities));
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
        //cities
        $cities = UserCities::model()->findAllAsArray();

        //create form-validator and model
        $form = new UserForm();

        //if got post from form
        if($_POST['UserForm'])
        {
            //set attributes to form model and user
            $form->attributes = $_POST['UserForm'];

            //if validation passed
            if($form->validate())
            {
                //get file from request
                $avatar = CUploadedFile::getInstance($form,'avatar');

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
                if($avatar->size > 0)
                {
                    //create new file-name
                    $new_file_name = uniqid('av_').'.'.$avatar->extensionName;

                    //if file saved
                    if($avatar->saveAs('images/user_thumbs/'.$new_file_name))
                    {
                        //set new avatar
                        $user->avatar = $new_file_name;
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
        $this->render('user_create', array('form_mdl' => $form, 'positions' => $positions, 'roles' => $roles, 'cities' => $cities));
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
            //cities
            $cities = UserCities::model()->findAllAsArray();

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
                if($form->validate())
                {
                    //get file from request
                    $avatar = CUploadedFile::getInstance($form,'avatar');

                    //set dates
                    $user->date_changed = time();

                    //who modified
                    $user->user_modified_by = Yii::app()->user->id;

                    //if have avatar
                    if($avatar->size > 0)
                    {
                        //create new file-name
                        $new_file_name = uniqid('av_').'.'.$avatar->extensionName;

                        //if avatar saved
                        if($avatar->saveAs('images/user_thumbs/'.$new_file_name))
                        {
                            //delete old avatar if exist
                            if($old_ava != '' && file_exists('images/user_thumbs/'.$old_ava))
                            {
                                unlink('images/user_thumbs/'.$old_ava);
                            }

                            //set new avatar
                            $user->avatar = $new_file_name;
                        }
                    }
                    //leave od avatar
                    else
                    {
                        $user->avatar = $old_ava;
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
            $this->render('user_edit', array('form_mdl' => $form, 'user' => $user, 'positions' => $positions, 'roles' => $roles, 'rights' => $rights, 'cities' => $cities));
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
        $user = Users::model()->with('serviceResolutions')->findByPk($id);

        //if user found
        if($user)
        {
            //if found usages in other tables
            if(count($user->serviceResolutions) > 0)
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

        //if some checkboxes checked
        if(!empty($rights_array) && is_array($rights_array))
        {
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

    /************************************************* A J A X  S E C T I O N *********************************************************************/


    public function actionResetPassword($id = 0)
    {
        //if ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //including swift mailer
            spl_autoload_unregister(array('YiiBase','autoload'));
            Yii::import('application.extensions.swift.swift_required', true);
            spl_autoload_register(array('YiiBase','autoload'));

            /* @var $user Users */
            $user = Users::model()->findByPk($id);

            //if found user
            if(!empty($user))
            {
                //try create new password
                try
                {
                    //create new random password
                    $new_password = uniqid();
                    $user->password = md5($new_password);
                    $user->update();
                }
                    //if failed
                catch(CDbException $e)
                {
                    $response = array();
                    $response['code'] = 'CREATE_ERROR';
                    exit (json_encode($response));
                }


                //send it to email
                $recipients = array($user->email => $user->username.' '.$user->surname);

                //email settings
                $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com',465);
                $transport->setEncryption('ssl');
                $transport->setUsername('erp.olivia@gmail.com');
                $transport->setPassword('olivia_password!');
                $mailer = Swift_Mailer::newInstance($transport);


                //message settings
                $message = Swift_Message::newInstance();
                $message->setSubject('Password reset');
                $message->setFrom(array('erp.olivia@gmail.com' => 'Ilux ERP System'));


                try
                {
                    $message->setTo($recipients);
                }
                catch(Swift_RfcComplianceException $e)
                {
                    $response = array();
                    $response['code'] = 'SEND_ERROR';
                    $response['password'] = $new_password;
                    exit (json_encode($response));
                }


                //set text
                $message->setBody($this->labels['your new password'].' - '.$new_password.'. '.$this->labels['you can change it in settings'], 'text/html');

                //try send to user
                try
                {
                    $mailer->send($message);
                    $response = array();
                    $response['code'] = 'OK';
                    exit (json_encode($response));
                }
                    //if failed
                catch(Exception $e)
                {
                    $response = array();
                    $response['code'] = 'SEND_ERROR';
                    $response['password'] = $new_password;
                    exit (json_encode($response));
                }

            }
            //if user not found
            else
            {
                throw new CHttpException(404);
            }
        }
        //if not ajax
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Auto-complete handler for name-surname in filtration template (usages : user_list.js, user_list.php)
     * @param $term
     * @param int $lim
     */
    public function actionAutoComplete($term,$lim = 5)
    {
        $arr = Users::model()->getAllByNameSurname($term);
        $arr = array_slice($arr,0,$lim);
        echo json_encode($arr);
    }//actionAutoComplete


    /**
     * Ajax filtration (usages : user_list.js, user_list.php)
     * @throws CHttpException
     */
    public function actionFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $name_surname = Yii::app()->request->getParam('name_surname','');
            $position_id = Yii::app()->request->getParam('position_id', '');
            $city_id = Yii::app()->request->getParam('city_id','');

            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            $c = new CDbCriteria();
            if(!empty($name_surname))
            {
                $words = explode(' ',$name_surname,2);

                if(count($words) > 1)
                {
                    $c -> addCondition("name LIKE '%".$words[0]."%' AND surname LIKE '%".$words[1]."%'");
                }
                else
                {
                    $c -> addCondition("name LIKE '%".$name_surname."%' OR surname LIKE '%".$name_surname."%'");
                }
            }
            if(!empty($position_id))
            {
                $c -> addInCondition('position_id',array($position_id));
            }
            if(!empty($city_id))
            {
                $c -> addInCondition('city_id',array($city_id));
            }

            //get all filtered items
            $items = Users::model()->findAll($c);

            //pagination, get all items for page
            $pager = new CPagerComponent($items,$on_page,$page);
            $this->renderPartial('_filtered_table',array('pager' => $pager));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilter

}