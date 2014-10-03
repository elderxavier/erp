<?php

class AjaxController extends Controller
{
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