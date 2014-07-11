<?php


class MainMenu extends Widget {


    public function run(){

        /* @var $rights UserRights */

        //get user rights
        $curr_controller = Yii::app()->controller->id;

        //array of menu-links
        $main_menu = array(
            'products' => array('controller' => 'products','image' => 'product.png','visible' => $this->rights['products_section_see'] ? 1 : 0 ),
            'contractors' => array('controller' => 'contractors', 'image' => 'kontragent.png', 'visible' => $this->rights['contractors_section_see'] ? 1 : 0),
            'employees' => array('controller' => 'employees', 'image' => 'person.png', 'visible' => $this->rights['employees_section_see'] ? 1 : 0)
        );

        $this->render('main_menu',array('links' => $main_menu, 'curr_controller' => $curr_controller));
    }
}
?>