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
            'add invoice' => array('action' => 'FirstStepCreate', 'visible' => $this->rights['sales_add'] ? 1 : 0, 'class' => 'create-product'),
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
        $form = new ClientForm();

        if(isset($_POST['ClientForm']))
        {
            //if company
            if($_POST['ClientForm']['company'])
            {
                //validate as company (company code required)
                $form->company = 1;
            }

            //set attributes and validate
            $form->attributes = $_POST['ClientForm'];

            //if no errors
            if($form->validate())
            {
                //empty client
                $client = new Clients();

                //set attributes
                $client->attributes = $_POST['ClientForm'];

                //set company or not
                $client->type = $form->company;

                //set creation parameters
                $client->date_created = time();
                $client->date_changed = time();
                $client->user_modified_by = Yii::app()->user->id;

                //save to db
                $client->save();

                //redirect to next step
                $this->redirect(Yii::app()->createUrl('/sell/nextStepCreate/',array('cid' => $client->id)));
            }
        }

        $this->render('first_step', array('form_mdl' => $form));
    }

    /**
     * Renders next step
     */
    public function actionNextStepCreate($cid = null)
    {
        Debug::out($cid);
        exit('');
    }
}