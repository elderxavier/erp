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
    public function actionInvoices($page = 1, $on_page = 3)
    {
        //get all invoices
        $invoices = OperationsIn::model()->with('supplier')->findAll();

        //pagination stuff
        $pagination = new CPagerComponent($invoices,$on_page);
        $invoices = $pagination->getPreparedArray($page);

        //render table
        $this->render('purchases_list', array('invoices' => $invoices, 'pager' => $pagination));
    }


    /**
     * Creation - step 1
     */
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


    /**************************************************** A J A X  S E C T I O N ********************************************************************/

    /**
     * auto-complete for purchase step1
     */
    public function actionSellers($term = '',$code = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = Suppliers::model()->getAllClientsJson($term,$code);
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionSellers


    /**
     * Ajax filter
     * @throws CHttpException
     */
    public function actionAjaxFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //params from post
            $invoice_code = Yii::app()->request->getParam('invoice_code','');
            $supplier_name = Yii::app()->request->getParam('supplier_name','');
            $date_from_str = Yii::app()->request->getParam('date_from_str','');
            $date_to_str = Yii::app()->request->getParam('date_to_str','');
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //default time range
            $time_from = 0;
            $time_to = time()+(60*60*24);

            //conditions
            $supp_name_condition = null;
            $inv_code_condition = null;

            //attribute conditions
            $attr_conditions = array();

            //if given dates
            if(!empty($date_from_str))
            {
                $dt = DateTime::createFromFormat('m/d/Y',$date_from_str);
                $time_from = $dt->getTimestamp();
            }
            if(!empty($date_to_str))
            {
                $dt = DateTime::createFromFormat('m/d/Y',$date_to_str);
                $time_to = $dt->getTimestamp();
                $time_to += (60*60*24); //add one day
            }

            $c = new CDbCriteria();


            //if invoice code set
            if(!empty($supplier_name))
            {
                $c ->addCondition('supplier.company_name LIKE "%'.$supplier_name.'%"');
            }

            //if invoice code set
            if(!empty($invoice_code))
            {
                $c -> addCondition('invoice_code LIKE "%'.$invoice_code.'%"');
            }

            //add between
            $c -> addBetweenCondition(OperationsIn::model()->tableAlias.'.date_created',$time_from,$time_to);

            //items
            $items = OperationsIn::model()->with(array('supplier'))->findAll($c);

            $pagination = new CPagerComponent($items,$on_page);
            $sliced_items  = $pagination->getPreparedArray($page);

            //render partial
            $this->renderPartial('_operations_filtering',array('items' => $sliced_items, 'pager' => $pagination));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAjaxFilter

    /**
     * Renders partial info of purchase
     * @param int $id
     * @throws CHttpException
     */
    public function actionAjaxInfo($id = 0)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $purchase = OperationsIn::model()->with('supplier','operationsInItems')->findByPk($id);
            if(!empty($purchase))
            {
                $this->renderPartial('_ajax_buy_info',array('purchase' => $purchase));
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
    }//actionAjaxInfo
}