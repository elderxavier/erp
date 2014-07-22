<?php

class ServicesController extends Controller
{
    /**
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'services' => array('action' => 'list','visible' => $this->rights['services_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add service' => array('action' => 'create', 'visible' => $this->rights['services_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        //do listing
        $this->actionList();
    }

    /**
     * List all processes
     */
    public function actionList()
    {
        //get all processes
        $processes = ServiceProcesses::model()->with('problemType','operation')->findAll();

        //render table
        $this->render('srv_list',array('services' => $processes));
    }

    /**
     * Create new service
     */
    public function actionCreate()
    {
        /* @var $worker_position Positions */

        //create new form-validator-model
        $form = new ServiceForm();

        //get all clients as array of pairs
        $clients = Clients::model()->findAllAsArray();

        //get all problem types as array of pairs
        $problems = ServiceProblemTypes::model()->findAllAsArray();

        //get worker position
        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker'));

        //get all workers
        $workers = $worker_position->getAllUsersAsArray();

        //cities
        $cities = UserCities::model()->findAllAsArray();

        //if got post
        if($_POST['ServiceForm'])
        {
            Debug::out($_POST);
            exit('test');
        }

        //render form
        $this->render('srv_create',array('form_mdl' => $form, 'clients' => $clients, 'problems' => $problems, 'cities' => $cities, 'workers' => $workers));
    }
}