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
        $invoices = InvoicesOut::model()->with('client')->findAll();

        //render table
        $this->render('sales_list', array('invoices' => $invoices));
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
            $invoices_count = InvoicesOut::model()->count();


            foreach($available_stocks as $stock){$available_stocks_id[] = $stock->id;}

            $this->render('next_step',array('stocks' => $stocks, 'available_stocks_id' => $available_stocks_id, 'client' => $client, 'options' => $options, 'vats' => $vats, 'count' => $invoices_count));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    public function actionFinalStep()
    {
        Debug::out($_POST);
        exit('test');
    }
}