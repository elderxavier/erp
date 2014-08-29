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
        $invoices = OperationsIn::model()->with('supplier')->findAll();

        //render table
        $this->render('purchases_list', array('invoices' => $invoices));
    }
    
    
    
    public function actionCreateStep1(){

        $form = new SupplierForm();

        //if got post
        if(isset($_POST['SupplierForm']))
        {
            //set attributes and validate
            $form->attributes = $_POST['SupplierForm'];

            //if no errors
            if($form->validate())
            {
                //create new supplier and set params
                $supplier = new Suppliers();
                $supplier->attributes = $_POST['SupplierForm'];

                //set creation parameters
                $supplier->date_created = time();
                $supplier->date_changed = time();
                $supplier->user_modified_by = Yii::app()->user->id;

                //save to db
                $supplier->save();

                //redirect to list
                $this->redirect('/'.$this->id.'/createinvoice/id/'.$supplier->id);
            }
        }

        $this->render('in_purchases_step1', array('form_mdl' => $form));
    }//step1


    /**
     * Render create-invoice page-form, if given post - create product card and then render form again
     * @param int $id supplier id
     * @throws CHttpException
     */
    public function actionCreateInvoice($id = null)
    {
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
                }
            }

            $categories_arr = ProductCardCategories::model()->getAllAsArray();
            $stocks = Stocks::model()->findAll();
            $this->render('create_invoice', array('supplier' => $supplier, 'stocks' => $stocks, 'categories_arr' => $categories_arr, 'form_mdl' => $form, 'card' => $card));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//createInvoice

    /**
     * Create invoice and operations
     * @throws CHttpException
     */
    public function actionFinishCreation()
    {
        /* @var $stock Stocks */
        /* @var $supplier Suppliers */

        if(isset($_POST['BuyForm']))
        {
            $supplier_id = $_POST['BuyForm']['supplier_id'];
            $stock_id = $_POST['BuyForm']['stock'];
            $products = $_POST['BuyForm']['products'];
            $signer_name = $_POST['BuyForm']['signer_name'];
            $invoice_code = $_POST['BuyForm']['invoice_code'];

            //try find stock and supplier
            $supplier = Suppliers::model()->findByPk($supplier_id);
            $stock = Stocks::model()->findByPk($stock_id);

            //if supplier and stock exist in base
            if($supplier && $stock)
            {
                //create new incoming invoice
                $invoice = new OperationsIn();

                //set main params
                $invoice->supplier_id = $supplier->id;
                $invoice->date_changed = time();
                $invoice->date_created = time();
                $invoice->signer_name = $signer_name;
                $invoice->invoice_code = $invoice_code;

                //save invoice in db
                $invoice->save();

                foreach($products as $id => $product_arr)
                {
                    $operation = new OperationsInItems(); //create incoming operation item
                    $operation -> operation_id = $invoice->id; //relation with invoice
                    $operation -> product_card_id = $id; //set product card
                    $operation -> qnt = $product_arr['qnt']; //quantity
                    $operation -> price = $this->priceStrToCents($product_arr['price']); //price
                    $operation -> stock_id = $stock_id; //stock id
                    $operation -> client_id = $supplier->id; //supplier
                    $operation -> stock_qnt_after_op = Stocks::model()->addToStockAndGetCount($id,$product_arr['qnt'],$stock->id); //add to stock and get current quantity in stock
                    $operation -> date = time(); //time of operation
                    $operation -> save(); //save to base
                }

                //redirect to list of invoices
                $this->redirect('/buy/invoices');
            }
            else
            {
                throw new CHttpException(404);
            }
        }
        else
        {
            throw new CHttpException(404);
        }
    }
}