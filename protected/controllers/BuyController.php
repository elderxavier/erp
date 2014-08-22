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
            $form = new ProductCardForm();
            $card = null;

            //if set post form params
            if(isset($_POST['ProductCardForm']))
            {
                $card = new ProductCards();
                //validate all attributes
                $form->attributes = $_POST['ProductCardForm'];

                //if no errors
                if($form->validate())
                {
                    //set params
                    $card->attributes = $_POST['ProductCardForm'];
                    $card->date_changed = time();
                    $card->date_created = time();
                    $card->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $card->save();

                    //get array of files
                    $files = CUploadedFile::getInstances($form,'files');

                    //save files
                    ProductFiles::model()->saveFiles($files,$card->id);
                }
            }

            $categories_arr = ProductCardCategories::model()->getAllAsArray();
            $stocks = Stocks::model()->findAll();
            $this->render('create_invoice', array('supplier' => $supplier, 'stocks' => $stocks, 'categories_arr' => $categories_arr, 'form_mdl' => $form, 'filter_by_code' => $card != null ? $card->product_code : ''));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//createInvoice
}