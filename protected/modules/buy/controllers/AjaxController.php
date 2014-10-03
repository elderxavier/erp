<?php

class AjaxController extends Controller
{
    public function actionAutoCompleteProductsCode($term = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCode('',$term,true));
            echo $result;
        }else{
            throw new CHttpException(404);
        }
    }

    public function actionAutoCompleteProductsName($term = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCode($term,'',true));
            echo $result;
        }else{
            throw new CHttpException(404);
        }
    }

    public function actionFindProductsModal()
    {
        $request = Yii::app()->request;
        if($request->isAjaxRequest){

            $name = $request->getPost('name');
            $code = $request->getPost('code');

            $rows = ProductCards::model()->findAllByNameOrCode($name,$code);
            $this->renderPartial('_find_prod_partial',array('rows' => $rows));

        }else{
            throw new CHttpException(404);
        }

    }//FindProductsModal


    public function actionSellInfo($id = null)
    {
        $id = (int)$id;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $data = Suppliers::model()->findByPk($id);
            $modal = $this->renderPartial('supp_info_modal',array('data' => $data,),true);
            echo $modal;
        }else{
            throw new CHttpException(404);
        }
    }//sellInfo



    public function actionSellFilter()
    {
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $name = $request->getPost('name', '');
            $code = $request->getPost('code', '');

            $data = Suppliers::model()->getSeller($name,$code);

            if(!empty($data)){
                echo $this->renderPartial('_filterSuppTable',array('data'=>$data),true);
            }else{
                echo $this->renderPartial('_emptyTable',array(),true);
            }

        }else{
            throw new CHttpException(404);
        }
    }// sellFilter

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


    /**
     * Ajax filter
     * @throws CHttpException
     */
    public function actionAjaxFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //params from post
            $invoice_code = Yii::app()->request->getParam('invoice_code','');
            $supplier_name = Yii::app()->request->getParam('supplier_name','');
            $date_from_str = Yii::app()->request->getParam('date_from_str','');
            $date_to_str = Yii::app()->request->getParam('date_to_str','');
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //default time range
            $time_from = 0;
            $time_to = time()+(60*60*24);

            //conditions
            $supp_name_condition = null;
            $inv_code_condition = null;

            //attribute conditions
            $attr_conditions = array();

            //if given dates
            if(!empty($date_from_str))
            {
                $dt = DateTime::createFromFormat('m/d/Y',$date_from_str);
                $time_from = $dt->getTimestamp();
            }
            if(!empty($date_to_str))
            {
                $dt = DateTime::createFromFormat('m/d/Y',$date_to_str);
                $time_to = $dt->getTimestamp();
                $time_to += (60*60*24); //add one day
            }

            $c = new CDbCriteria();


            //if invoice code set
            if(!empty($supplier_name))
            {
                $c ->addCondition('supplier.company_name LIKE "%'.$supplier_name.'%"');
            }

            //if invoice code set
            if(!empty($invoice_code))
            {
                $c -> addCondition('invoice_code LIKE "%'.$invoice_code.'%"');
            }

            //add between
            $c -> addBetweenCondition(OperationsIn::model()->tableAlias.'.date_created',$time_from,$time_to);

            //items
            $items = OperationsIn::model()->with(array('supplier'))->findAll($c);

            $pagination = new CPagerComponent($items,$on_page,$page);

            //render partial
            $this->renderPartial('_operations_filtering',array('pager' => $pagination));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAjaxFilter

    /**
     * Renders partial info of purchase
     * @param int $id
     * @throws CHttpException
     */
    public function actionAjaxInfo($id = 0)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $purchase = OperationsIn::model()->with('supplier','operationsInItems')->findByPk($id);
            if(!empty($purchase))
            {
                $this->renderPartial('_ajax_buy_info',array('purchase' => $purchase));
            }
            else
            {
                throw new CHttpException(404);
            }
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAjaxInfo
}