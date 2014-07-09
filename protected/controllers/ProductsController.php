<?php

class ProductsController extends Controller
{

    public static function GetSubMenu()
    {
        /* @var $user_rights UserRights */

        $user_rights = Controller::GetUserRights();

        $arr = array(
            'Add category' => array('action' => 'addcat', 'visible' => $user_rights->products_categories_create, 'class' => 'create-product'),
            'Categories' => array('action' => 'categories','visible' => $user_rights->products_see , 'class' => 'list-products'),
            'Add product card' => array('action' => 'addcard', 'visible' => $user_rights->products_cards_create, 'class' => 'create-product'),
            'Product cards' => array('action' => 'cards', 'visible' => $user_rights->products_see, 'class' => 'list-products'),
        );

        return $arr;
    }

    //I N D E X
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id.'/categories'));
    }

    //L I S T  C A T E G O R I E S
    public function actionCategories()
    {
        //get all categories from database
        $categories = ProductCardCategories::model()->findAll();

        //render list
        $this->render('list_categories',array('categories' => $categories));
    }

    //A D D  C A T E G O R Y
    public function actionAddCat()
    {
        $this->render('edit_category');
    }

}