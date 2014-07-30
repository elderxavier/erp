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
     * Create new service-process
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

                        //set info-params
                        $client->type = $form_clients->company;
                        $client->date_changed = time();
                        $client->user_modified_by = Yii::app()->user->id;

                        //if created new client
                        if($client->isNewRecord)
                        {
                            //creation time
                            $client->date_created = time();
                            //save in db
                            $client->save();
                        }
                        //if old
                        else
                        {
                            //update
                            $client->update();
                        }


                        //create service process
                        $service_process = new ServiceProcesses();

                        //info params
                        $service_process -> date_created = time();
                        $service_process -> date_changed = time();
                        $service_process -> user_modified_by = Yii::app()->user->id;
                        $service_process -> user_created_by = Yii::app()->user->id;

                        //'start' and 'end' dates (will be set in future, now used defaults)
                        $service_process -> start_date = time(); // default - current day
                        $service_process -> close_date = time() + (24*60*60); // default - tomorrow

                        //set main params
                        $service_process -> problem_type_id = $_POST['ServiceForm']['problem_type_id']; //relation with problems table
                        $service_process -> remark = $_POST['ServiceForm']['remark']; //description
                        $service_process -> client_id = $client->id; //relation with clients table
                        $service_process -> label = 'some key'; //system name of record (empty for now, in future will be generated from ID)
                        $service_process -> priority = $_POST['ServiceForm']['priority']; //priority - string value
                        $service_process -> status_id = ServiceProcessStatuses::model()->systemStatusId('SYS_OPENED'); //get id of OPENED status
                        $service_process -> current_employee_id = $_POST['ServiceForm']['worker_id']; //lastly set employee

                        //save service process
                        $service_process -> save();

                        //create first resolution
                        $resolution = new ServiceResolutions();
                        $resolution -> service_process_id = $service_process->id; //relation with service-process which was created
                        $resolution -> by_employee_id = $_POST['ServiceForm']['worker_id']; //relation with employee
                        $resolution -> remark_for_employee = $service_process -> remark; //for first resolution used description of service process
                        $resolution -> process_current_status = $service_process -> status; //current status of service-process
                        $resolution -> status = ServiceResolutions::ST_NEW; //status of resolution - new

                        //info params
                        $resolution -> date_created = time();
                        $resolution -> date_changed = time();
                        $resolution -> user_modified_by = Yii::app()->user->id;

                        //save service resolution
                        $resolution -> save();

                        //check priority of service
                        switch($service_process -> priority)
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

    /**
     * Edits service process
     * @param null $id
     */
    public function actionEdit($id = null)
    {
        /* @var $worker_position Positions */
        /* @var $service_process ServiceProcesses */
        /* @var $form SrvEditForm*/

        //create service-editing-form
        $form = new SrvEditForm();

        //arrays for select boxes and other elements
        $cities = array('ALL' => $this->labels['all']) + UserCities::model()->findAllAsArray(); // cities as pairs-array
        $problem_types = json_encode(ServiceProblemTypes::model()->findAllAsArray()); // problem types (used in editable)
        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker')); //worker position object
        $workers = $worker_position->getAllUsersAsArray(); //all workers as pairs-array
        $statuses = ServiceProcessStatuses::model()->findAll(array(),array('order' => 'priority ASC')); //array of statuses

        //find service-process
        $srv_process = ServiceProcesses::model()->with('client','problemType','currentEmployee','serviceResolutions','status')->findByPk($id);

        //if get post from form
        if($_POST['SrvEditForm'])
        {
            //set attributes to form
            $form->attributes = $_POST['SrvEditForm'];

            //if validated
            if($form->validate())
            {
                //if service process found
                if($service_process = ServiceProcesses::model()->findByPk($id))
                {
                    //set new params to service process
                    $service_process->problem_type_id = $_POST['SrvEditForm']['problem_type_id'];
                    $service_process->remark = $_POST['SrvEditForm']['remark'];
                    $service_process->status_id = $_POST['SrvEditForm']['status'];
                    $service_process->current_employee_id = $_POST['SrvEditForm']['worker_id'];

                    //info params
                    $service_process->user_modified_by = Yii::app()->user->id;
                    $service_process->date_changed = time();

                    //update service process
                    $service_process->update();

                    //if given message to worker
                    if($_POST['SrvEditForm']['message_to_worker'] != '')
                    {
                        //create resolution
                        $resolution = new ServiceResolutions();
                        $resolution -> service_process_id = $service_process->id; //relation with service-process which was created
                        $resolution -> by_employee_id = $service_process->current_employee_id; //relation with employee
                        $resolution -> remark_for_employee = $_POST['SrvEditForm']['message_to_worker']; //for first resolution used description of service process
                        $resolution -> process_current_status = $service_process -> status_id; //current status of service-process
                        $resolution -> status = ServiceResolutions::$statuses['NEW']['id'];

                        //info params
                        $resolution -> date_created = time();
                        $resolution -> date_changed = time();
                        $resolution -> user_modified_by = Yii::app()->user->id;

                        //save service resolution
                        $resolution->save();
                    }

                    //redirect to current action
                    $this->redirect('/services/edit/'.$id);
                }
            }
        }

        //render form
        $this->render('srv_edit',array('service' => $srv_process, 'problem_types' => $problem_types, 'cities' => $cities, 'workers' => $workers, 'form_mdl' => $form, 'statuses' => $statuses));
    }
}