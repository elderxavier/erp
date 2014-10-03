<?php

class MainController extends Controller
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
        //if manager
        if(Yii::app()->user->getState('position_id') == 1)
        {
            //get all services
            $processes = ServiceProcesses::model()->with('problemType','operation', 'serviceResolutions')->findAll();
        }
        //if worker
        else
        {
            //get just related with current user services
            $processes = ServiceProcesses::model()->with('problemType','operation','serviceResolutions')->findAllByAttributes(array('current_employee_id' => Yii::app()->user->id));
        }

        //render table
        $this->render('srv_list',array('services' => $processes));
    }


    public function actionContinueFromNew()
    {
        Debug::out($_POST);
        exit();
    }

    /**
     * Renders first-step form of service creation
     */
    public function actionCreate()
    {
        //create new form-validator-model for service
        $form = new ServiceForm();
        $form_clients = new ClientForm();

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
                $this->redirect(Yii::app()->createUrl('/services/continue/',array('id' => $client->id)));
            }
        }

        //array for types-select-box
        $types = ClientTypes::model()->findAllAsArray();
        $emptyLabel = array('' => $this->labels['select type']);
        $types =  $emptyLabel + $types;

        //render form
        $this->render('srv_create', array('client_types' => $types, 'form_mdl' => $form, 'form_cli_mdl' => $form_clients));
    }


    /**
     * Renders second-step form of service creation
     * @param int $id
     * @throws CHttpException
     */
    public function actionContinue($id = 0)
    {
        /* @var $client Clients */
        /* @var $worker_position Positions */
        /* @var $process ServiceProcesses */
        /* @var $form SrvEditForm*/

        //find client from list
        $client = Clients::model()->findByPk($id);

        //client
        if($client)
        {
            $form = new ServiceForm(); //create validation-form
            $problems = ServiceProblemTypes::model()->findAllAsArray(); //problem types
            $cities = array('ALL' => $this->labels['all']) + UserCities::model()->findAllAsArray(); // cities as pairs-array
            $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker')); /*TODO: it's a bad solution to use the name as the key, should think about better*/
            $workers = $worker_position->getAllUsersAsArray(); //all workers as pairs-array

            //if POST given
            if($_POST['ServiceForm'])
            {
                //set attributes
                $form->attributes = $_POST['ServiceForm'];

                //if validated
                if($form->validate())
                {
                    //convert string do date-time objects
                    $start_dt = DateTime::createFromFormat('n/d/Y',$_POST['ServiceForm']['start_date']);
                    $close_dt = DateTime::createFromFormat('n/d/Y',$_POST['ServiceForm']['close_date']);

                    //create new service process
                    $process = new ServiceProcesses();
                    //set main params
                    $process->attributes = $_POST['ServiceForm'];
                    $process->status_id = ServiceProcessStatuses::model()->systemStatusId('SYS_OPENED'); /* system statuses: SYS_OPENED, SYS_PROGRESS, SYS_CLOSED */
                    $process->current_employee_id = $_POST['ServiceForm']['worker_id'];
                    $process->client_id = $client->id;

                    $process->start_date = $start_dt->getTimestamp();
                    $process->close_date = $close_dt->getTimestamp();

                    //set info params
                    $process->date_created = time();
                    $process->date_changed = time();
                    $process->user_modified_by = Yii::app()->user->id;
                    $process->user_created_by = Yii::app()->user->id;
                    $process->read_by_employee = 0;
                    //save process
                    $process->save();

                    //create first resolution
                    $resolution = new ServiceResolutions();
                    //set main params
                    $resolution->by_employee_id = $_POST['ServiceForm']['worker_id'];
                    $resolution->remark_for_employee = $process->remark;
                    $resolution->status = ServiceResolutions::$statuses['NEW']['id'];
                    $resolution->process_current_status = $process->status_id;
                    $resolution->service_process_id = $process->id;
                    //save resolution
                    $resolution->save();


                    //redirect to list
                    $this->redirect('/services/list/');
                }
            }

            //render form
            $this->render('srv_create_continue',array('form_mdl' => $form, 'client' => $client, 'problems' => $problems, 'workers' => $workers, 'cities' => $cities));
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Edits service process
     * @param null $id
     */
    public function actionEdit($id = null)
    {
        /* @var $worker_position Positions */
        /* @var $service_process ServiceProcesses */
        /* @var $srv_process ServiceProcesses */
        /* @var $form SrvEditForm*/

        //create service-editing-form
        $form = new SrvEditForm();

        //arrays for select boxes and other elements
        $cities = array('ALL' => $this->labels['all']) + UserCities::model()->findAllAsArray(); // cities as pairs-array
        $problem_types = json_encode(ServiceProblemTypes::model()->findAllAsArray()); // problem types (used in editable)
        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker')); /*TODO: it's a bad solution to use the name as the key, should think about better*/
        $workers = $worker_position->getAllUsersAsArray(); //all workers as pairs-array
        $statuses = ServiceProcessStatuses::model()->findAll(array(),array('order' => 'priority ASC')); //array of statuses

        //find service-process
        $srv_process = ServiceProcesses::model()->with('client','problemType','currentEmployee','serviceResolutions','status')->findByPk($id);

        //read if current employee - target
        if($srv_process->current_employee_id == Yii::app()->user->id)
        {
            $srv_process->read_by_employee = 1;
            $srv_process->update();
        }


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