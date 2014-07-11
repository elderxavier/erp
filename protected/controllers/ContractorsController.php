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
        $this->render('create_client');
    }
}