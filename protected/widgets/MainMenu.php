<?php


class MainMenu extends CWidget {


    public function run(){

        /* @var $rights UserRights */

        //get user rights
        $rights = Yii::app()->user->GetState('rights');

        //default action for all links
        $default_action = 'index';

        //array of menu-links
        $main_menu = array(
            'products' => array('controller' => 'products','image' => 'stock.png','visible' => $rights->products_see),
            'contractors' => array('controller' => 'contractors', 'image' => 'kontragent.png', 'visible' => $rights->contractors_see),
            'employees' => array('controller' => 'employees', 'image' => 'person.png', 'visible' => $rights->users_see)
        );

        $this->render('main_menu',array('links' => $main_menu, 'default_action' => $default_action));
    }
}
?>