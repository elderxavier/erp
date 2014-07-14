<?php

class ContractorsController extends Controller
{
    //R E T U R N S  S U B M E N U  F O R  T H I S  C O N T R O L L E R
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

    //I N D E X
    public function actionIndex()
    {
        $this->actionClients();
    }

    /****************************************************************************************************************
     *********************************************** C L I E N T S **************************************************
     ***************************************************************************************************************/

    //L I S T
    public function actionClients()
    {
        //get all clients and service which client waits
        $clients = Clients::model()->with('nextService','firstInvoice')->findAll();

        //actions for every record
        $actions = array(
            'edit' => array('controller' => Yii::app()->controller->id, 'action' => 'editclient', 'class' => 'actions action-edit', 'visible' => $this->rights['clients_edit'] ? 1 : 0),
            'delete' => array('controller' => Yii::app()->controller->id, 'action' => 'deleteclient', 'class' => 'actions action-delete' , 'visible' => $this->rights['clients_delete'] ? 1 : 0),
        );

        //render
        $this->render('list_clients', array('clients' => $clients, 'table_actions' => $actions));
    }

    //A D D
    public function actionAddCli()
    {
        $this->render('create_clients');
    }

    //E D I T
    public function actionEditClient($id = null)
    {
        //try find by pk
        $client = Clients::model()->findByPk($id);

        //if not found - throw 404 exception
        if(empty($client)){throw new CHttpException(404,$this->labels['item not found in base']);}

        //render form
        $this->render('edit_clients',array('client' => $client));
    }

    //D E L E T E
    public function actionDeleteClient($id = null)
    {
        /* @var $client Clients */
        $restricts = array();

        //try find by pk
        $client = Clients::model()->with('invoicesOuts','lastService','nextService')->findByPk($id);

        //if not found - throw 404 exception
        if(empty($client)){throw new CHttpException(404,$this->labels['item not found in base']);}

        //if exist some invoices related with this client
        if(count($client->invoicesOuts) > 0){$restricts[]=$this->labels['this item used in'].' '.$this->labels['outgoing invoices'];}

        //if no restricts
        if(empty($restricts))
        {
            //delete
            $client->delete();

            //redirect to list
            $this->redirect(Yii::app()->createUrl($this->id.'/clients'));
        }
        //if some restricts
        else
        {
            //render restrict pages
            $this->render('restricts',array('restricts' => $restricts));
        }

    }

    //U P D A T E
    public function actionUpdateClient()
    {
        //get main params from request
        $id = Yii::app()->request->getParam('id','');
        $personal_code = Yii::app()->request->getParam('personal_code','');
        $vat_code = Yii::app()->request->getParam('vat_code','');
        $name = Yii::app()->request->getParam('name','');
        $surname = Yii::app()->request->getParam('surname','');
        $phone_1 = Yii::app()->request->getParam('phone_1','');
        $phone_2 = Yii::app()->request->getParam('phone_2','');
        $email_1 = Yii::app()->request->getParam('email_1','');
        $email_2 = Yii::app()->request->getParam('email_2','');
        $remark = Yii::app()->request->getParam('remark','');
        $remark_service = Yii::app()->request->getParam('remark_service','');
        $company = Yii::app()->request->getParam('company',false);
        $company_name = Yii::app()->request->getParam('company_name','');
        $company_code = Yii::app()->request->getParam('company_code','');

        //try find by pk
        $client = Clients::model()->findByPk($id);

        //if not found - create new
        if(empty($client)){$client = new Clients();}

        //create validator
        $validator = new ClientForm();
        //company or not
        $company != false ? $validator->company = true : $validator->company = false;
        //set current client id to validator, to avoid unique-check-error when updating
        if(!$client->isNewRecord){$validator->current_client_id = $client->id;}

        //set attributes and validate
        $validator->attributes = $_POST;
        $validator->validate();

        //get validation errors
        $errors = $validator->getErrors();

        //if no errors
        if(empty($errors))
        {
            //set main params
            $client->personal_code = $personal_code;
            $client->vat_code = $vat_code;
            $client->name = $name;
            $client->surname = $surname;
            $client->phone1 = $phone_1;
            $client->phone2 = $phone_2;
            $client->email1 = $email_1;
            $client->email2 = $email_2;
            $client->remark = $remark;
            $client->remark_for_service = $remark_service;
            if($company!=false){$client->type = 1;}else{$client->type = 0;}
            $client->company_name = $company_name;
            $client->company_code = $company_code;
            $client->date_changed = time();
            $client->user_modified_by = Yii::app()->user->id;

            //if new client
            if($client->isNewRecord)
            {
                //save new
                $client->date_created = time();
                $client->save();
            }
            //if old
            else
            {
                //update
                $client->update();
            }

            //redirect to list
            $this->redirect(Yii::app()->createUrl($this->id.'/clients'));
        }
        //if some errors
        else
        {
            //if this was creating attempt
            if($client->isNewRecord)
            {
                //render creating form with errors
                $this->render('create_clients',array('errors' => $errors));
            }
            //if this was updating attempt
            else
            {
                //render updating form with errors
                $this->render('edit_clients',array('client' => $client, 'errors' => $errors));
            }
        }
    }


    /****************************************************************************************************************
     ******************************************* S U P P L I E R S **************************************************
     ***************************************************************************************************************/

    //L I S T
    public function actionSuppliers()
    {
        //get all clients and service which client waits
        $suppliers = Suppliers::model()->findAll();

        //actions for every record
        $actions = array(
            'edit' => array('controller' => Yii::app()->controller->id, 'action' => 'editsupp', 'class' => 'actions action-edit', 'visible' => $this->rights['suppliers_edit'] ? 1 : 0),
            'delete' => array('controller' => Yii::app()->controller->id, 'action' => 'deletesupp', 'class' => 'actions action-delete' , 'visible' => $this->rights['suppliers_delete'] ? 1 : 0),
        );

        //render
        $this->render('list_suppliers', array('suppliers' => $suppliers, 'table_actions' => $actions));
    }

    //E D I T
    public function actionEditSupp($id = null)
    {
        //try find by pk
        $supplier = Suppliers::model()->findByPk($id);

        //if not found - throw 404 exception
        if(empty($supplier)){throw new CHttpException(404,$this->labels['item not found in base']);}

        //render form
        $this->render('edit_suppliers',array('supplier' => $supplier));
    }

    //C R E A T E
    public function actionAddSup()
    {
        $this->render('create_suppliers');
    }

    //U P D A T E
    public function actionUpdateSupplier()
    {
        //get main params from request
        $id = Yii::app()->request->getParam('id','');
        $personal_code = Yii::app()->request->getParam('personal_code','');
        $vat_code = Yii::app()->request->getParam('vat_code','');
        $name = Yii::app()->request->getParam('name','');
        $surname = Yii::app()->request->getParam('surname','');
        $phone_1 = Yii::app()->request->getParam('phone_1','');
        $phone_2 = Yii::app()->request->getParam('phone_2','');
        $email_1 = Yii::app()->request->getParam('email_1','');
        $email_2 = Yii::app()->request->getParam('email_2','');
        $remark = Yii::app()->request->getParam('remark','');
        $company = Yii::app()->request->getParam('company',false);
        $company_name = Yii::app()->request->getParam('company_name','');
        $company_code = Yii::app()->request->getParam('company_code','');

        //try find by pk
        $supplier = Suppliers::model()->findByPk($id);

        //if not found - create new
        if(empty($supplier)){$supplier = new Suppliers();}

        //create validator
        $validator = new SupplierForm();
        //company or not
        $company != false ? $validator->company = true : $validator->company = false;
        //set current client id to validator, to avoid unique-check-error when updating
        if(!$supplier->isNewRecord){$validator->current_supplier_id = $supplier->id;}

        //set attributes and validate
        $validator->attributes = $_POST;
        $validator->validate();

        //get validation errors
        $errors = $validator->getErrors();

        //if no errors
        if(empty($errors))
        {
            //set main params
            $supplier->personal_code = $personal_code;
            $supplier->vat_code = $vat_code;
            $supplier->name = $name;
            $supplier->surname = $surname;
            $supplier->phone1 = $phone_1;
            $supplier->phone2 = $phone_2;
            $supplier->email1 = $email_1;
            $supplier->email2 = $email_2;
            $supplier->remark = $remark;
            if($company!=false){$supplier->type = 1;}else{$supplier->type = 0;}
            $supplier->company_name = $company_name;
            $supplier->company_code = $company_code;
            $supplier->date_changed = time();
            $supplier->user_modified_by = Yii::app()->user->id;

            //if new client
            if($supplier->isNewRecord)
            {
                //save new
                $supplier->date_created = time();
                $supplier->save();
            }
            //if old
            else
            {
                //update
                $supplier->update();
            }

            //redirect to list
            $this->redirect(Yii::app()->createUrl($this->id.'/suppliers'));
        }
        //if some errors
        else
        {
            //if this was creating attempt
            if($supplier->isNewRecord)
            {
                //render creating form with errors
                $this->render('create_suppliers',array('errors' => $errors));
            }
            //if this was updating attempt
            else
            {
                //render updating form with errors
                $this->render('edit_suppliers',array('client' => $supplier, 'errors' => $errors));
            }
        }
    }
}