<?php


class MainMenu extends Widget {

    public function run(){

        /* @var $rights UserRights */

        //get user rights
//        $curr_controller = Yii::app()->controller->id;
        $curr_controller = Yii::app()->controller->module->id;

        //array of menu-links
        $main_menu = array(
            'products' => array('controller' => 'products','image' => 'product.png','visible' => $this->rights['products_see'] || $this->rights['categories_see'] ? 1 : 0 ),
            'contractors' => array('controller' => 'contractors', 'image' => 'kontragent.png', 'visible' => $this->rights['clients_see'] || $this->rights['suppliers_see'] ? 1 : 0),
            'employees' => array('controller' => 'users', 'image' => 'person.png', 'visible' => $this->rights['users_see'] ? 1 : 0),
            'purchases' => array('controller' => 'buy', 'image' => 'buy.png', 'visible' => $this->rights['purchases_see'] ? 1 : 0),
            'sales' => array('controller' => 'sell', 'image' => 'sell.png', 'visible' => $this->rights['sales_see'] ? 1 : 0),
            'services' => array('controller' => 'services', 'image' => 'services.png', 'visible' => $this->rights['services_see'] ? 1 : 0),
            'stock' => array('controller' => 'stock', 'image' => 'stock.png', 'visible' => $this->rights['stock_see'] ? 1 : 0),
            'reports' => array('controller' => 'reports', 'image' => 'stock.png', 'visible' => $this->rights['stock_see'] ? 1 : 0)
        );

        $this->render('main_menu',array('links' => $main_menu, 'curr_controller' => $curr_controller));
    }
}
?>