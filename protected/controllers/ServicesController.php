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
     *
     */
    public function actionCreate()
    {
        //create new form-validator-model for service
        $form = new ServiceForm();

        //array for types-select-box
        $types = array('' => 'Select', 0 => $this->labels['physical'], 1 => $this->labels['juridical']);

        //render form
        $this->render('srv_create', array('client_types' => $types, 'form_mdl' => $form));
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
        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker')); /*TODO: it's a bad solution to use the name as the key, should think about better*/
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