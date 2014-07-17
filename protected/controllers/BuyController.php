<?php

class BuyController extends Controller
{
    /**
     * Returns sub-menu for controller
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'invoices' => array('action' => 'invoices','visible' => $this->rights['purchases_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add invoice' => array('action' => 'create', 'visible' => $this->rights['purchases_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->actionCreate();
    }

    /**
     * Make new purchase invoice
     */
    public function actionCreate()
    {
        $suppliers = Suppliers::model()->findAll();
        $products = ProductCards::model()->findAllByAttributes(array('status' => 1));

        $this->render('sales_create',array('suppliers' => $suppliers, 'products' => $products));
    }
}