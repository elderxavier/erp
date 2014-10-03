<?php

class AjaxController extends Controller
{
    public function actionOperationOutInfo($id = null)
    {
        if($operation = OperationsOut::model()->findByPk($id))
        {
            $this->renderPartial('_operation_out',array('operation' => $operation));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    public function actionFilterByStockCodeAndName()
    {
        $request = Yii::app()->request;
        if($request->isAjaxRequest)
        {
            $name = $request->getPost('name');
            $code = $request->getPost('code');
            $stock = $request->getPost('stock');

            $result = ProductCards::model()->findAllByNameOrCodeAndStock($name,$code,$stock);
            echo $this->renderPartial('_filtered_for_sales',array('items' => $result),true);

        }
        else
        {
            throw new CHttpException(404);
        }
    }

    public function actionAutoCompleteFromStockByName($term = null, $stock = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCodeAndStock($term,'',$stock,true));
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    public function actionAutoCompleteFromStockByCode($term = null, $stock = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCodeAndStock('',$term,$stock,true));
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Generates invoice-pdf and sets code
     * @param $id
     * @throws CHttpException
     */
    public function actionGenerate($id)
    {
        /* @var $operation OperationsOut */

        $operation = OperationsOut::model()->findByPk($id);
        if(!empty($operation))
        {
            $invoice_code = $operation->invoice_code;

            if($operation->invoice_code == '')
            {
                $current_stock_id = $operation->stock->id;

                $c = new CDbCriteria();
                $c -> addInCondition('stock_id',array($current_stock_id));
                $c -> addNotInCondition('invoice_code',array(''));

                $operations_with_code_count = (int)OperationsOut::model()->count($c);
                $current_invoice_nr = (string)($operations_with_code_count + 1);
                $invoice_code = $operation->stock->location->prefix.'_'.str_pad($current_invoice_nr,4,'0',STR_PAD_LEFT);

                $operation->invoice_code = $invoice_code;
                $operation->invoice_date = time();
                $operation->update();
            }

            $ret = array('key' => $invoice_code, 'link' => Yii::app()->createUrl('/pdf/invoice', array('id' => $id)));
            echo json_encode($ret);
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionGenerate

    /**
     * Filter table ajax
     */
    public function actionFilterTable()
    {
        //get all params from post(or get)
        $client_name = Yii::app()->request->getParam('cli_name', '');
        $client_type_id = Yii::app()->request->getParam('cli_type_id',null);
        $invoice_code = Yii::app()->request->getParam('in_code','');
        $operation_status_id = Yii::app()->request->getParam('in_status_id','');
        $stock_city_id = Yii::app()->request->getParam('stock_city_id','');
        $date_from_str = Yii::app()->request->getParam('date_from_str','');
        $date_to_str = Yii::app()->request->getParam('date_to_str','');
        $page = Yii::app()->request->getParam('page',1);
        $on_page = Yii::app()->request->getParam('on_page',3);

        //date range by default
        $time_from = 0;
        $time_to = time() + (60 * 60 * 24);

        //criteria
        $c = new CDbCriteria();

        //if client name not empty
        if(!empty($client_name))
        {
            if(!empty($client_type_id))
            {
                //if not company (physical person)
                if($client_type_id != 1)
                {
                    $names = explode(" ",$client_name,2);
                    if(count($names) > 1)
                    {
                        $c -> addCondition('client.name LIKE "%'.$names[0].'%" AND client.surname LIKE "%'.$names[1].'%"');
                    }
                    else
                    {
                        $c -> addCondition('client.name LIKE "%'.$client_name.'%"');
                    }
                }

                //if company
                else
                {
                    $c -> addCondition('client.company_name LIKE "%'.$client_name.'%"');
                }
            }
            else
            {
                $names = explode(" ",$client_name,2);
                if(count($names) > 1)
                {
                    $c -> addCondition('client.name LIKE "%'.$names[0].'%" AND client.surname LIKE "%'.$names[1].'%" OR client.company_name LIKE "%'.$client_name.'%"');
                }
                else
                {
                    $c -> addCondition('client.name LIKE "%'.$client_name.'%" OR client.company_name LIKE "%'.$client_name.'%"');
                }
            }
        }
        elseif(!empty($client_type_id))
        {
            $c -> addCondition('client.type = '.$client_type_id.'');
        }

        if(!empty($stock_city_id))
        {
            $c -> addCondition('stock.location_id = '.$stock_city_id.'');
        }

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

        //if invoice code set
        if(!empty($invoice_code))
        {
            $c -> addInCondition('invoice_code',array($invoice_code));
        }

        //if operation status set
        if(!empty($operation_status_id))
        {
            $c -> addInCondition('status_id',array($operation_status_id));
        }

        //search between times
        $c -> addBetweenCondition('date_created_ops',$time_from,$time_to);

        //get all items by conditions and limit them by criteria
        $operations = OperationsOut::model()->with(array('client','stock.location'))->findAll($c);

        $pagination = new CPagerComponent($operations,$on_page,$page);

        //render partial
        $this->renderPartial('_ajax_table_filtering',array('pager' => $pagination));

    }//actionFilterTable
}