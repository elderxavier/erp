<?php
class PersonalSettings extends Widget {

    //default dir for user avatars
    public $avatar_dir = '/images/user_thumbs/';

    //entry point
    public function run(){

        /* @var $user_record Users */

        //name, surname, avatar - empty strings by default
        $name = '';
        $surname = '';
        $avatar = '';

        //find user record in db
        $user_record = Users::model()->findByPk(Yii::app()->user->id);

        //if user found
        if(!empty($user_record))
        {
            //set name, surname, avatar
            $name = $user_record->name;
            $surname = $user_record->surname;
            $avatar = $this->avatar_dir.$user_record->avatar;
        }

        //links
        $links = array(
            'logout' => array('controller' => 'main', 'action' => 'logout', 'class' => 'logout'),
            'settings' => array('controller' => 'main', 'action' => 'personal', 'class' => 'user-edit'),
            'options' => array('controller' => 'main', 'action' => 'options', 'class' => 'user-options'),
        );

        //render
        $this->render('personal_settings',array('links' => $links, 'name' => $name, 'surname' => $surname, 'avatar' => $avatar));
    }
}