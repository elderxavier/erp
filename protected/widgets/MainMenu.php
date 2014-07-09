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
            'Products' => array('controller' => 'products','image' => 'stock.png','visible' => $rights->products_see),
            'Contractors' => array('controller' => 'contractors', 'image' => 'kontragent.png', 'visible' => $rights->contractors_see),
            'Employees' => array('controller' => 'employees', 'image' => 'person.png', 'visible' => $rights->users_see)
        );

        $this->render('_main_menu',array('links' => $main_menu, 'default_action' => $default_action));
    }
}
?>