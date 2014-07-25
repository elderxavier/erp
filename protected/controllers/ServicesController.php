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
        $processes = ServiceProcesses::model()->with('problemType','operation', 'serviceResolutions')->findAll();

        //render table
        $this->render('srv_list',array('services' => $processes));
    }

    /**
     * Create new service
     */
    public function actionCreate()
    {
        /* @var $worker_position Positions */

        //create new form-validator-model for service
        $form_service = new ServiceForm();

        //create new form-validator-model for clients
        $form_clients = new ClientForm();

        //get all clients as array of pairs
        $clients = Clients::model()->findAllAsArray();

        //get all problem types as array of pairs
        $problems = ServiceProblemTypes::model()->findAllAsArray();

        //get worker position
        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker'));

        //get all workers
        $workers = $worker_position->getAllUsersAsArray();

        //cities
        $cities = array('ALL' => $this->labels['all']) + UserCities::model()->findAllAsArray();

        //if got something from post
        if($_POST)
        {
            //if got service form and client form
            if($_POST['ServiceForm'] && $_POST['client'])
            {
                //set attributes to form-model
                $form_service->attributes = $_POST['ServiceForm'];

                //if main service params valid
                if($form_service->validate())
                {
                    //get client id
                    $client_id = $_POST['client']['id'] ? $_POST['client']['id'] : null;
                    $company = $_POST['client']['type'] ? $_POST['client']['type'] : 0;

                    //current client id (null if new client)
                    $form_clients->current_client_id = $client_id;

                    //company or not
                    $form_clients->company = $company;

                    //set to client-form-validator all client attributes
                    $form_clients->attributes = $_POST['client'];

                    //if client form validated
                    if($form_clients->validate())
                    {
                        //find or create client
                        $client_id ? $client = Clients::model()->findByPk($client_id) : $client = new Clients();
                        //set all attributes
                        $client->attributes = $_POST['client'];
                        //save or update
                        $client->isNewRecord ? $client->save() : $client->update();

                        //create service process
                        $service_process = new ServiceProcesses();

                        //info params
                        $service_process -> date_created = time();
                        $service_process -> date_changed = time();
                        $service_process -> user_modified_by = Yii::app()->user->id;

                        //start and end dates (will be set in future, now used defaults)
                        $service_process -> start_date = time(); // defaults - current day
                        $service_process -> close_date = time() + (24*60*60); // defaults - tomorrow

                        //set main params
                        $service_process -> problem_type_id = $_POST['ServiceForm']['problem_type_id'];
                        $service_process -> remark = $_POST['ServiceForm']['remark'];
                        $service_process -> client_id = $client->id;
                        $service_process -> label = 'empty label';
                        $service_process -> status = ServiceProcesses::ST_OPENED;

                        //save service process
                        $service_process -> save();

                        //create first resolution
                        $resolution = new ServiceResolutions();
                        $resolution -> service_process_id = $service_process->id;
                        $resolution -> by_employee_id = $_POST['ServiceForm']['worker_id'];
                        $resolution -> remark_for_employee = $service_process -> remark;
                        $resolution -> process_current_status = $service_process -> status;
                        $resolution -> status = ServiceResolutions::ST_NEW;

                        //info params
                        $resolution -> date_created = time();
                        $resolution -> date_changed = time();
                        $resolution -> user_modified_by = Yii::app()->user->id;

                        //save service resolution
                        $resolution -> save();

                        //check priority of service
                        switch($_POST['ServiceForm']['priority'])
                        {
                            case 'low':
                                //TODO: just notification on site
                                break;
                            case 'medium':
                                //TODO: send email to worker
                                break;
                            case 'high':
                                //TODO: send SMS to worker
                                break;
                        }

                        //TODO: open new outgoing invoice, new service-operation and save all info

                        //redirect to list
                        $this->redirect('/services/list');
                    }
                }
            }
            //if client missed
            elseif(!$_POST['client'])
            {
                //TODO: some react to client data-missing
                exit('client not selected');
            }
        }

        //render form
        $this->render('srv_create',array('form_mdl' => $form_service, 'form_cli' => $form_clients, 'clients' => $clients, 'problems' => $problems, 'cities' => $cities, 'workers' => $workers));
    }
}