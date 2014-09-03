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

        $types = ClientTypes::model()->findAllAsArray();
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
        $types = ClientTypes::model()->findAllAsArray();
        $emptyLabel = array('' => $this->labels['select type']);
        $types =  $emptyLabel + $types;

        $this->render('first_step', array('form_mdl' => $form_clients, 'form_srv' => $form_srv, 'client_types' => $types));
    }

    /**
     * Renders next step
     */
    public function actionNextStepCreate($id = null)
    {
        /* @var $stocks Stocks[] */
        /* @var $available_stocks Stocks[] */

        if($client = Clients::model()->findByPk($id))
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
            $operation->status_id = 2; /* 2 - on the way, 1 - delivered */
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


    /****************************************** A J A X  S E C T I O N ************************************************/

    /**
     * Generates invoice-pdf and sets code
     * @param $id
     * @throws CHttpException
     */
    public function actionGenerate($id)
    {
        /* @var $operation OperationsOut */

        if($operation = OperationsOut::model()->findByPk($id))
        {
            $invoice_code = $operation->invoice_code;

            if($operation->invoice_code == '')
            {
                $current_stock_id = $operation->stock->id;

                $c = new CDbCriteria();
                $c -> addInCondition('stock_id',array($current_stock_id));
                $c -> addNotInCondition('invoice_code',array(''));

                $operations_with_code_count = (int)OperationsOut::model()->count($c);
                $current_invoice_nr = (string)($operations_with_code_count + 1);
                $invoice_code = $operation->stock->location->prefix.'_'.str_pad($current_invoice_nr,4,'0',STR_PAD_LEFT);

                $operation->invoice_code = $invoice_code;
                $operation->invoice_date = time();
                $operation->update();
            }

            $ret = array('key' => $invoice_code, 'link' => Yii::app()->createUrl('/pdf/invoice', array('id' => $id)));
            echo json_encode($ret);
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionGenerate



    /**
     * Filter table ajax
     */
    public function actionFilterTable()
    {
        //get all params from post(or get)
        $client_name = Yii::app()->request->getParam('cli_name', '');
        $client_type_id = Yii::app()->request->getParam('client_type_id',null);
        $invoice_code = Yii::app()->request->getParam('in_code','');
        $operation_status_id = Yii::app()->request->getParam('in_status_id','');
        $stock_city_id = Yii::app()->request->getParam('stock_city_id','');
        $date_from_str = Yii::app()->request->getParam('date_from_str','');
        $date_to_str = Yii::app()->request->getParam('date_to_str','');

        //new criteria for filtering
        $c = new CDbCriteria();

        //if has invoice code
        if(!empty($invoice_code))
        {
            //add to condition (search by invoice code)
            $c -> addInCondition('invoice_code',array($invoice_code));
        }

        //if have client-name
        if(!empty($client_name))
        {
            //get all client-rows from base by name and type (where name, or company name like $client_name parameter)
            $clients = Clients::model()->getClients($client_name,$client_type_id);

            //if found some clients
            if(count($clients) > 0)
            {
                //declare empty array for client's ids
                $found_ids = array();

                //fill array of client ids
                foreach($clients as $client_row)
                {
                    $found_ids[] = $client_row['id'];
                }

                //add ids to condition (search by client ids)
                $c -> addInCondition('client_id',$found_ids);
            }
        }

        //if operation status set
        if(!empty($operation_status_id))
        {
            //search by status
            $c -> addInCondition('status_id',array($operation_status_id));
        }

        //if city_id not empty
        if(!empty($stock_city_id))
        {
            /* @var $city UserCities */

            //get city by id
            $city = UserCities::model()->findByPk($stock_city_id);

            //get stocks by city
            $stocks = $city->stocks;

            //if found some stocks
            if(count($stocks) > 0)
            {
                //get first stock (usually city has only one stock)
                $stock = $stocks[0];
                //find by stock id
                $c -> addInCondition('stock_id',array($stock->id));
            }
        }

        //if 'date-from' not empty but 'date-to' empty
        if(!empty($date_from_str) && empty($date_to_str))
        {
            $date_from_arr = explode('/',$date_from_str); //explode string to get numbers
            $time_from = mktime(0,0,0,(int)$date_from_arr[0],(int)$date_from_arr[1],(int)$date_from_arr[2]); // make time
            $time_to = 9999999999; //maximal time ('date-to' not set)
            $c -> addBetweenCondition('date_created',$time_from,$time_to); //search between these times
        }

        //if 'date-to' not empty but 'date-from' empty
        if(!empty($date_to_str) && empty($date_from_str))
        {
            $date_to_arr = explode('/',$date_to_str); //explode string to get numbers
            $time_from = 0; //beginning of time ('date-from' not set)
            $time_to = mktime(0,0,0,(int)$date_to_arr[0],(int)$date_to_arr[1],(int)$date_to_arr[2]); // make time
            $c -> addBetweenCondition('date_created',$time_from,$time_to); //search between these times
        }

        //if 'date-to' and 'date-from' not empty
        if(!empty($date_from_str) && !empty($date_to_str))
        {
            $date_from_arr = explode('/',$date_from_str); //explode string to get numbers
            $time_from = mktime(0,0,0,(int)$date_from_arr[0],(int)$date_from_arr[1],(int)$date_from_arr[2]); // make time
            $date_to_arr = explode('/',$date_to_str); //explode string to get numbers
            $time_to = mktime(0,0,0,(int)$date_to_arr[0],(int)$date_to_arr[1],(int)$date_to_arr[2]); // make time
            $c -> addBetweenCondition('date_created',$time_from,$time_to); //search between these times
        }

        //get all operations
        $operations = OperationsOut::model()->findAll($c);

        //render partial
        $this->renderPartial('_ajax_table_filtering',array('operations' => $operations));

    }//FilterTable
}