<?php

class ContractorsController extends Controller
{
    /**
     * Returns sub-menu for controller
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'clients' => array('action' => 'clients','visible' => $this->rights['clients_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add clients' => array('action' => 'addcli', 'visible' => $this->rights['clients_add'] ? 1 : 0, 'class' => 'create-product'),
            'suppliers' => array('action' => 'suppliers', 'visible' => $this->rights['suppliers_see'] ? 1 : 0, 'class' => 'list-products'),
            'add supplier' => array('action' => 'addsupp', 'visible' => $this->rights['suppliers_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->actionClients();
    }

    /****************************************************************************************************************
     *********************************************** C L I E N T S **************************************************
     ***************************************************************************************************************/

    /**
     * List clients
     */
    public function actionClients()
    {
        //get all clients and service which client waits
        $clients = Clients::model()->with('nextService','firstInvoice')->findAll();

        //render
        $this->render('client_list', array('clients' => $clients));
    }

    /**
     *Add client
     */
    public function actionAddCli()
    {
        //empty client
        $client = new Clients();

        //form-validate object
        $form = new ClientForm();

        //if got post
        if(isset($_POST['ClientForm']))
        {
            //if company
            if($_POST['ClientForm']['company'])
            {
                //validate as company (company code required)
                $form->company = 1;
                //set type to client (1 = company)
                $client->type = 1;
            }

            //set attributes and validate
            $form->attributes = $_POST['ClientForm'];
            $client->attributes = $_POST['ClientForm'];
            $form->validate();

            //if no errors
            if(!$form->hasErrors())
            {
                //set creation parameters
                $client->date_created = time();
                $client->date_changed = time();
                $client->user_modified_by = Yii::app()->user->id;

                //save to db
                $client->save();

                //redirect to list
                $this->redirect('/'.$this->id.'/clients');
            }
        }

        $this->render('client_create', array('client' => $client, 'form_mdl' => $form));
    }


    /**
     * Edit client
     * @param null $id
     * @throws CHttpException
     */
    public function actionEditClient($id = null)
    {
        /* @var $client Clients */

        //try find by pk
        $client = Clients::model()->findByPk($id);

        //if found
        if(!empty($client))
        {
            //form-validate object
            $form = new ClientForm();

            //set current client-id to validator, to avoid unique-check-error when updating
            $form->current_client_id = $client->id;

            //if got post
            if(isset($_POST['ClientForm']))
            {
                //if company
                if($_POST['ClientForm']['company'])
                {
                    //validate as company (company code required)
                    $form->company = 1;
                    //set type to client (1 = company)
                    $client->type = 1;
                }

                //set attributes and validate
                $form->attributes = $_POST['ClientForm'];
                $client->attributes = $_POST['ClientForm'];

                //if no errors
                if($form->validate())
                {
                    //set creation parameters
                    $client->date_created = time();
                    $client->date_changed = time();
                    $client->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $client->save();

                    //redirect to list
                    $this->redirect('/'.$this->id.'/clients');
                }
            }

            $this->render('client_edit', array('client' => $client, 'form_mdl' => $form));
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }

    /**
     * Delete client
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteClient($id = null)
    {
        /* @var $client Clients */

        //try find by pk
        $client = Clients::model()->with('invoicesOuts','lastService','nextService')->findByPk($id);

        //if found
        if(!empty($client))
        {
            //if exist some invoices related with this client
            if(count($client->invoicesOuts) > 0)
            {
                $this->render('restricts');
            }
            //if no usages
            else
            {
                //delete
                $client->delete();

                //redirect to list
                $this->redirect(Yii::app()->createUrl('/'.$this->id.'/clients'));
            }
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }

    }


    /****************************************************************************************************************
     ******************************************* S U P P L I E R S **************************************************
     ***************************************************************************************************************/

    /**
     * List all suppliers
     */
    public function actionSuppliers()
    {
        //get all clients and service which client waits
        $suppliers = Suppliers::model()->findAll();

        //render
        $this->render('supplier_list', array('suppliers' => $suppliers));
    }

    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionEditSupp($id = null)
    {
        /* @var $supplier Clients */

        //try find by pk
        $supplier = Suppliers::model()->findByPk($id);

        //if found
        if(!empty($supplier))
        {
            //form-validate object
            $form = new SupplierForm();

            //set current client-id to validator, to avoid unique-check-error when updating
            $form->current_supplier_id = $supplier->id;

            //if got post
            if(isset($_POST['SupplierForm']))
            {
                //if company
                if($_POST['SupplierForm']['company'])
                {
                    //validate as company (company code required)
                    $form->company = 1;
                    //set type to client (1 = company)
                    $supplier->type = 1;
                }

                //set attributes and validate
                $form->attributes = $_POST['SupplierForm'];
                $supplier->attributes = $_POST['SupplierForm'];

                //if no errors
                if($form->validate())
                {
                    //set creation parameters
                    $supplier->date_created = time();
                    $supplier->date_changed = time();
                    $supplier->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $supplier->save();

                    //redirect to list
                    $this->redirect('/'.$this->id.'/suppliers');
                }
            }

            $this->render('supplier_edit', array('supplier' => $supplier, 'form_mdl' => $form));
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }

    /**
     * Create supplier
     * @throws CHttpException
     */
    public function actionAddSup()
    {
        /* @var $supplier Clients */

        //try find by pk
        $supplier = new Suppliers();

        //if found
        if(!empty($supplier))
        {
            //form-validate object
            $form = new SupplierForm();

            //set current client-id to validator, to avoid unique-check-error when updating
            $form->current_supplier_id = $supplier->id;

            //if got post
            if(isset($_POST['SupplierForm']))
            {
                //if company
                if($_POST['SupplierForm']['company'])
                {
                    //validate as company (company code required)
                    $form->company = 1;
                    //set type to client (1 = company)
                    $supplier->type = 1;
                }

                //set attributes and validate
                $form->attributes = $_POST['SupplierForm'];
                $supplier->attributes = $_POST['SupplierForm'];

                //if no errors
                if($form->validate())
                {
                    //set creation parameters
                    $supplier->date_created = time();
                    $supplier->date_changed = time();
                    $supplier->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $supplier->save();

                    //redirect to list
                    $this->redirect('/'.$this->id.'/suppliers');
                }
            }

            $this->render('supplier_create', array('supplier' => $supplier, 'form_mdl' => $form));
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }

    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteSupp($id = null)
    {
        /* @var $supplier Suppliers */

        //try find by pk
        $supplier = Suppliers::model()->with('invoicesIns','lastService','nextService')->findByPk($id);

        //if found
        if(!empty($supplier))
        {
            //if exist some invoices related with this client
            if(count($supplier->invoicesIns) > 0)
            {
                $this->render('restricts');
            }
            //if no usages
            else
            {
                //delete
                $supplier->delete();

                //redirect to list
                $this->redirect(Yii::app()->createUrl('/'.$this->id.'/suppliers'));
            }
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }

    }
}