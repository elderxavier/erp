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
            'add invoice' => array('action' => 'createstep1', 'visible' => $this->rights['purchases_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        //do listing
        $this->actionInvoices();
    }

    /**
     * List all invoices
     */
    public function actionInvoices()
    {
        //get all invoices
        $invoices = InvoicesIn::model()->with('supplier')->findAll();

        //render table
        $this->render('purchases_list', array('invoices' => $invoices));
    }
    
    
    
    public function actionCreateStep1(){
        $this->render('in_purchases_step1');
    }//step1
    
    
    public function actionCreateInvoice($id = null){
        if($supplier = Suppliers::model()->findByPk($id))
        {
            $this->render('create_invoice', array('supplier' => $supplier));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//createInvoice
}