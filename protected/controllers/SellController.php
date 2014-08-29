<?php

class SellController extends Controller
{
    /**
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'invoices' => array('action' => 'invoices','visible' => $this->rights['sales_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add invoice' => array('action' => 'firststepcreate', 'visible' => $this->rights['sales_add'] ? 1 : 0, 'class' => 'create-product'),
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
     * Render invoice table
     */
    public function actionInvoices()
    {
        //get all sale-invoices
        $invoices = OperationsOut::model()->with('client')->findAll();

        $types = array(0 => $this->labels['physical'],1 => $this->labels['juridical']);
        $statuses = OperationOutStatuses::model()->findAllAsArray();
        $cities = UserCities::model()->findAllAsArray();

        //render table
        $this->render('sales_list', array('invoices' => $invoices, 'types' => $types, 'cities' => $cities, 'statuses' => $statuses));
    }

    /**
     * Render first step table
     */
    public function actionFirstStepCreate($id = null)
    {
        $form_clients = new ClientForm();
        $form_srv = new ServiceForm();

        if(isset($_POST['ClientForm']))
        {
            //if company
            if($_POST['ClientForm']['company'])
            {
                //validate as company (company code required)
                $form_clients->company = 1;
            }

            //set attributes and validate
            $form_clients->attributes = $_POST['ClientForm'];

            //if no errors
            if($form_clients->validate())
            {
                //empty client
                $client = new Clients();

                //set attributes
                $client->attributes = $_POST['ClientForm'];

                //set company or not
                $client->type = $form_clients->company;

                //set creation parameters
                $client->date_created = time();
                $client->date_changed = time();
                $client->user_modified_by = Yii::app()->user->id;

                //save to db
                $client->save();

                //redirect to next step
                $this->redirect(Yii::app()->createUrl('/sell/nextstepcreate/',array('cid' => $client->id)));
            }
        }

        //array for types-select-box
        $types = array('' => 'Select', 0 => $this->labels['physical'], 1 => $this->labels['juridical']);

        $this->render('first_step', array('form_mdl' => $form_clients, 'form_srv' => $form_srv, 'client_types' => $types));
    }

    /**
     * Renders next step
     */
    public function actionNextStepCreate($cid = null)
    {
        /* @var $stocks Stocks[] */
        /* @var $available_stocks Stocks[] */

        if($client = Clients::model()->findByPk($cid))
        {
            $available_stocks_id = array();
            $stocks = Stocks::model()->findAll();
            $options = OptionCards::model()->findAllByAttributes(array('status' => 1));
            $vats = Vat::model()->findAll();
            $available_stocks = Stocks::model()->findAllByAttributes(array('location_id' => Yii::app()->user->getState('city_id')));
            $invoices_count = OperationsOut::model()->count();


            foreach($available_stocks as $stock){$available_stocks_id[] = $stock->id;}

            $this->render('next_step',array('stocks' => $stocks, 'available_stocks_id' => $available_stocks_id, 'client' => $client, 'options' => $options, 'vats' => $vats, 'count' => $invoices_count));
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    public function actionFinalStep($generate = false)
    {
        /* @var $stock Stocks */
        /* @var $client Clients */

        $form = $_POST['SaleFrom'];
        $stock_id = $form['stock_id'];
        $client_id = $form['client_id'];
        $vat_id = $form['vat_id'];
        $products = $form['products'];
        $options = $form['options'];

        if($stock = Stocks::model()->findByPk($stock_id) && $client = Clients::model()->findByPk($client_id))
        {
            $operation = new OperationsOut();
            $operation->client_id = $client_id;
            $operation->signer_name = "";
//            $operation->payment_method_id = 0;
            $operation->date_created = time();
            $operation->date_changed = time();
            $operation->warranty_start_date = time();
            $operation->user_modified_by = Yii::app()->user->id;
            $operation->vat_id = $vat_id;
            $operation->invoice_code = '';
            $operation->stock_id = $stock_id;
            $operation->status_id = 0;
            $operation->save();

            foreach($products as $pr_card_id => $product_item)
            {
                if($product_item['qnt'] > 0 && $product_item['price'] > 0 && is_numeric($product_item['price']))
                {
                    $item_prod = new OperationsOutItems();
                    $item_prod -> price = $this->priceStrToCents($product_item['price']);
                    $item_prod -> discount_percent = $product_item['discount'];
                    $item_prod -> qnt = $product_item['qnt'];
                    $item_prod -> product_card_id = $pr_card_id;
                    $item_prod -> operation_id = $operation->id;
                    $item_prod -> stock_id = $stock_id;
                    $item_prod -> stock_qnt_after_op = Stocks::model()->removeFromStockAndGetCount($pr_card_id,$product_item['qnt'],$stock_id);
                    $item_prod -> client_id = $client_id;
                    $item_prod -> save();
                }
            }

            foreach($options as $op_card_id => $option_item)
            {
                if($option_item['price'] > 0 && is_numeric($option_item['price']))
                {
                    $item_option = new OperationsOutOptItems();
                    $item_option -> operation_id = $operation->id;
                    $item_option ->option_card_id = $op_card_id;
                    $item_option -> price = $this->priceStrToCents($option_item['price']);
                    $item_option -> qnt = 1;
                    $item_option -> client_id = $client_id;
                    $item_option -> save();
                }
            }
        }

        $this->redirect(Yii::app()->createUrl('/sell/invoices'));
    }
}