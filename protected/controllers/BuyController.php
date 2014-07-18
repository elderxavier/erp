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
        $this->render('sales_list', array('invoices' => $invoices));
    }


    /**
     * Make new purchase invoice
     */
    public function actionCreate()
    {
        /* @var $supplier Suppliers */
        /* @var $stock Stocks */

        //if given POST
        if($_POST['BuyForm'])
        {

            //get main params from post
            $products_params = $_POST['BuyForm']['products'];
            $supplier_id = $_POST['BuyForm']['supplier_id'];
            $stock_id = $_POST['BuyForm']['stock_id'];
            $invoice_code = $_POST['BuyForm']['invoice_code'];
            $signer_name = $_POST['BuyForm']['signer'];

            //try find stock and supplier
            $supplier = Suppliers::model()->findByPk($supplier_id);
            $stock = Stocks::model()->findByPk($stock_id);

            //if found supplier and stock
            if($supplier && $stock)
            {
                //create new incoming invoice
                $invoice = new InvoicesIn();

                //set main params
                $invoice->supplier_id = $supplier->id;
                $invoice->date_changed = time();
                $invoice->date_created = time();
                $invoice->signer_name = $signer_name;
                $invoice->invoice_code = $invoice_code;

                //save invoice in db
                $invoice->save();

                //for each param block
                foreach($products_params as $param_block)
                {
                    //create incoming operation
                    $operation = new OperationsIn();
                    //relation with invoice
                    $operation -> invoice_id = $invoice->id;
                    //set product card
                    $operation -> product_card_id = $param_block['card_id'];
                    //quantity
                    $operation -> qnt = $param_block['quantity'];
                    //price
                    $operation -> price = $this->priceStrToCents($param_block['price']);
                    //stock id
                    $operation -> stock_id = $stock_id;
                    //supplier
                    $operation -> client_id = $supplier->id;
                    //add to stock and get current quantity in stock
                    $operation -> stock_qnt_after_op = Stocks::model()->addToStockAndGetCount($param_block['card_id'],$param_block['quantity'],$stock_id);
                    //time of operation
                    $operation -> date = time();
                    //save to base
                    $operation -> save();
                }

                //redirect to list of invoices
                $this->redirect('/buy/invoices');
            }
            //throw 404
            else
            {
                throw new CHttpException(404);
            }
        }
        //if not given POST
        else
        {
            $suppliers = Suppliers::model()->findAll();
            $products = ProductCards::model()->findAllByAttributes(array('status' => 1));
            $stocks = Stocks::model()->findAll();

            $this->render('sales_create',array('suppliers' => $suppliers, 'products' => $products, 'stocks' => $stocks));
        }

    }
}