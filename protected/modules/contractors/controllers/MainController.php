<?php

class MainController extends Controller
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
    public function actionClients($page = 1, $on_page = 3)
    {
        //get all clients and service which client waits
        $clients = Clients::model()->with('firstInvoice')->findAll();

        //pagination obj with all items on this page
        $pager = new CPagerComponent($clients,$on_page,$page);

        //types ans cities for select boxes
        $types = ClientTypes::model()->findAllAsArray();
        $cities = array('Vilnius','Kaunas','Panevezys');

        //render
        $this->render('client_list', array('pager' => $pager, 'types' => $types, 'cities' => $cities));
    }

    /**
     *Add client
     */
    public function actionAddCli()
    {
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
                $form->company == 1 ? $client->type = 1 : $client->type = 2;

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

        //render form
        $this->render('client_create', array('form_mdl' => $form));
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
                    //set updating parameters
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
        $client = Clients::model()->with('operationsOuts', 'serviceProcesses')->findByPk($id);

        //if found
        if(!empty($client))
        {
            //if exist some invoices related with this client
            if(count($client->operationsOuts) > 0 || count($client->serviceProcesses) > 0)
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


    /****************************************** A J A X  S E C T I O N *********************************************/


    public function actionCusInfoSales($id = null)
    {
        $id = (int)$id;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $data = Clients::model()->findByPk($id);
            $modal = $this->renderPartial('_customer_info_modal_sales',array('client' => $data),true);
            echo $modal;
        }else{
            throw new CHttpException(404);
        }
    }//cusInfoSales

    public function actionCusFilterSales()
    {
        $request = Yii::app()->request;

        if($request->isAjaxRequest){

            $name = $request->getPost('name');
            $type = $request->getPost('type');


            $data = Clients::model()->getClients($name,$type);

            if(!empty($data)){
                echo $this->renderPartial('_filterTableSales',array('data'=>$data,'type' => $type),true);
            }else{
                echo $this->renderPartial('_emptyTable',array(),true);
            }

        }else{
            throw new CHttpException(404);
        }
    }//cusFilterSales

    public function actionCustinfo($id = null)
    {
        $id = (int)$id;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $data = Clients::model()->findByPk($id);
            $modal = $this->renderPartial('_customer_info_modal',array('client' => $data),true);
            echo $modal;
        }else{
            throw new CHttpException(404);
        }
    }//custInfo

    public function actionCustFilter()
    {
        $request = Yii::app()->request;

        if($request->isAjaxRequest){

            $name = $request->getPost('name');
            $type = $request->getPost('type');


            $data = Clients::model()->getClients($name,$type);

            if(!empty($data)){
                echo $this->renderPartial('_filterTable',array('data'=>$data,'type' => $type),true);
            }else{
                echo $this->renderPartial('_emptyTable',array(),true);
            }

        }else{
            throw new CHttpException(404);
        }
    }// cusFilter


    public function actionFSelector($id = null)
    {

        if(Yii::app()->request->isAjaxrequest){

            if($id == 1){
                echo $this->renderPartial('_filter_jur',array(),true);
            }else{
                echo $this->renderPartial('_filter_fiz',array(),true);
            }

        }else{
            throw new CHttpException(404);
        }

    }//Fselector

    /**
     * Prints json-converted array of client-ids and client-names (used for auto-complete)
     * @param int $term
     * @param int $type
     * @throws CHttpException
     */
    public function actionAjaxClients($term=null,$type=null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = Clients::model()->getAllClientsJson($term,$type);
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }

    }//Clients

    public function actionFilterClients()
    {
        //filter params
        $code = Yii::app()->request->getParam('code','');
        $name = Yii::app()->request->getParam('name','');
        $email = Yii::app()->request->getParam('email','');
        $type_id = Yii::app()->request->getParam('type_id','');
        $city_name = Yii::app()->request->getParam('city_name','');

        //pagination params
        $page = Yii::app()->request->getParam('page',1);
        $on_page = Yii::app()->request->getParam('on_page',3);

        //filtration criteria
        $c = new CDbCriteria();

        //if type set
        if(!empty($type_id))
        {
            //search by type
            $c->addInCondition('type',array($type_id));
        }
        //if city name set
        if(!empty($city_name))
        {
            //search by city name
            $c->addCondition("city LIKE '%".$city_name."%'");
        }

        //if email set
        if(!empty($email))
        {
            //search by two emails
            $c->addCondition("email1 LIKE '%".$email."%' OR email2 LIKE '%".$email."%'");
        }

        //if code set
        if(!empty($code))
        {
            //if client-type set
            if(!empty($type_id))
            {
                //if not company
                if($type_id == 2)
                {
                    //search all not-companies
                    $c -> addCondition("personal_code LIKE '%".$code."%'");
                }
                //if company
                if($type_id == 1)
                {
                    //search all companies
                    $c -> addCondition("company_code LIKE '%".$code."%'");
                }
            }
            //if type not set
            else
            {
                //search all companies and not-companies
                $c -> addCondition("personal_code LIKE '%".$code."%' OR company_code LIKE '%".$code."%'");
            }
        }

        //if name set
        if(!empty($name))
        {
            //explode name by space
            $words = explode(' ',$name,2);

            if(count($words) > 1)
            {
                $c -> addCondition("(name LIKE '%".$words[0]."%' AND surname LIKE '%".$words[1]."%') OR (company_name LIKE '%".$name."%')");
            }
            else
            {
                $c -> addCondition("name LIKE '%".$name."%' OR surname LIKE '%".$name."%' OR company_name LIKE '%".$name."%'");
            }
        }

        //filtered clients
        $clients = Clients::model()->findAll($c);

        //on one page
        $pager = new CPagerComponent($clients,$on_page,$page);

        //render
        $this->renderPartial('_client_filtered',array('pager' => $pager));
    }


    /****************************************************************************************************************
     ******************************************* S U P P L I E R S **************************************************
     ***************************************************************************************************************/

    /**
     * List all suppliers
     */
    public function actionSuppliers($page = 1, $on_page = 3)
    {
        //get all clients and service which client waits
        $suppliers = Suppliers::model()->findAll();

        //cities for select-boxes
        $cities = array('Vilnius','Kaunas','Panevezys');

        $pager = new CPagerComponent($suppliers,$on_page,$page);

        //render
        $this->render('supplier_list', array('pager' => $pager, 'cities' => $cities));
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
                //set attributes and validate
                $form->attributes = $_POST['SupplierForm'];
                $supplier->attributes = $_POST['SupplierForm'];

                //if no errors
                if($form->validate())
                {
                    //set updating parameters
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
    public function actionAddSupp()
    {
        //form-validate object
        $form = new SupplierForm();

        //if got post
        if(isset($_POST['SupplierForm']))
        {
            //set attributes and validate
            $form->attributes = $_POST['SupplierForm'];


            //if no errors
            if($form->validate())
            {
                //create new supplier and set params
                $supplier = new Suppliers();
                $supplier->attributes = $_POST['SupplierForm'];

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

        $this->render('supplier_create', array('form_mdl' => $form));
    }

    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteSupp($id = null)
    {
        /* @var $supplier Suppliers */

        //try find by pk
        $supplier = Suppliers::model()->with('operationsIns')->findByPk($id);

        //if found
        if(!empty($supplier))
        {
            //if exist some invoices related with this client
            if(count($supplier->operationsIns) > 0)
            {
                $this->render('restricts');
            }
            //if no usages
            else
            {
                //delete
                $supplier->delete();

                //redirect to list
                $this->redirect('/'.$this->id.'/suppliers');
            }
        }
        //if not found
        else
        {
            //exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }


    /****************************************************** A J A X  S E C T I O N ******************************************************************/


    /**
     * auto-complete for purchase step1
     */
    public function actionSellers($term = '',$code = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = Suppliers::model()->getAllClientsJson($term,$code);
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionSellers


    public function actionFilterSuppliers()
    {
        //filter params
        $code = Yii::app()->request->getParam('code','');
        $name = Yii::app()->request->getParam('name','');
        $email = Yii::app()->request->getParam('email','');
        $city_name = Yii::app()->request->getParam('city_name','');

        //pagination params
        $page = Yii::app()->request->getParam('page',1);
        $on_page = Yii::app()->request->getParam('on_page',3);

        //filtration criteria
        $c = new CDbCriteria();

        //if city name set
        if(!empty($city_name))
        {
            //search by city name
            $c->addCondition("city LIKE '%".$city_name."%'");
        }

        //if email set
        if(!empty($email))
        {
            //search by two emails
            $c->addCondition("email1 LIKE '%".$email."%' OR email2 LIKE '%".$email."%'");
        }

        //if code set
        if(!empty($code))
        {
            //search all companies
            $c -> addCondition("company_code LIKE '%".$code."%'");
        }

        //if name set
        if(!empty($name))
        {
            $c -> addCondition("company_name LIKE '%".$name."%'");
        }

        //filtered clients
        $clients = Suppliers::model()->findAll($c);

        //on one page
        $pager = new CPagerComponent($clients,$on_page,$page);

        //render
        $this->renderPartial('_supplier_filtered',array('pager' => $pager));
    }


}