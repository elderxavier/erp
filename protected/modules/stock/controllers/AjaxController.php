<?php

class AjaxController extends Controller
{

    /**
     * Auto-complete for products name and code
     * @param string $name
     * @param string $code
     * @throws CHttpException
     */
    public function actionAutoCompleteProductCards($name = '',$code = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCode($name,$code,true));
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAutoCompleteProductCards


    /**
     * Auto-complete for products name and code by stock
     * @param string $name
     * @param string $code
     * @param int $stock
     * @throws CHttpException
     */
    public function actionAutoCompleteProductCardsByStock($name = '',$code = '',$stock = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = json_encode(ProductCards::model()->findAllByNameOrCodeAndStock($name,$code,$stock,true));
            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAutoCompleteProductCardsByStock

    /**
     * Filter products by stock, code, name - for movement form and render table
     * @throws CHttpException
     */
    public function actionProdFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $name = Yii::app()->request->getParam('name','');
            $code = Yii::app()->request->getParam('code','');
            $stock = Yii::app()->request->getParam('stock','');

            $result = ProductCards::model()->findAllByNameOrCodeAndStock($name,$code,$stock);

            $this->renderPartial('_ajax_products_filtering',array('products' => $result));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionProdFilter


    /**
     * Ajax filtration for stock-products
     * @throws CHttpException
     */
    public function actionFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $prod_name = Yii::app()->request->getParam('name','');
            $prod_code = Yii::app()->request->getParam('code','');
            $stock_loc_id = Yii::app()->request->getParam('location','');
            $units = Yii::app()->request->getParam('units','');
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //criteria for pagination
            $c = new CDbCriteria();

            //conditions - null by default
            $product_con_arr = null;
            $measure_con_arr = null;
            $location_con_arr = null;

            //if have product name and product code
            if(!empty($prod_name) && !empty($prod_code))
            {
                $c -> addCondition('productCard.product_name LIKE "%'.$prod_name.'%" AND productCard.product_code LIKE "%'.$prod_code.'%"');
//                $product_con_arr = array('condition'=>'productCard.product_name LIKE "%'.$prod_name.'%" AND productCard.product_code LIKE "%'.$prod_code.'%"');
            }
            //if have just product name
            elseif(!empty($prod_name))
            {
                $c -> addCondition('productCard.product_name LIKE "%'.$prod_name.'%"');
//                $product_con_arr = array('condition'=>'productCard.product_name LIKE "%'.$prod_name.'%"');
            }
            //if have just product code
            elseif(!empty($prod_code))
            {
                $c -> addCondition('productCard.product_code LIKE "%'.$prod_code.'%"');
//                $product_con_arr = array('condition'=>'productCard.product_code LIKE "%'.$prod_code.'%"');
            }

            //if have units
            if(!empty($units))
            {
                $c -> addCondition('measureUnits.id= '.$units);
//                $measure_con_arr = array('condition'=>'measureUnits.id= '.$units);
            }

            //if have location
            if(!empty($stock_loc_id))
            {
                $c -> addCondition('location.id= '.$stock_loc_id);
//                $location_con_arr = array('condition'=>'location.id= '.$stock_loc_id);
            }


            //get all items by conditions and limit them by criteria
            $items = ProductInStock::model()->with(array(
                'productCard',
                'productCard.measureUnits',
                'stock',
                'stock.location'))->findAll($c);


            $pagination = new CPagerComponent($items,$on_page,$page);

            //render table and pages
            $this->renderPartial('_ajax_table_filtering',array('pager' => $pagination));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilter


    public function actionMovementFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //get filter-params
            $movement_id = Yii::app()->request->getParam('movement_id',null);
            $src_stock_id = Yii::app()->request->getParam('src_stock_id',null);
            $trg_stock_id = Yii::app()->request->getParam('trg_stock_id',null);
            $date_from_str = Yii::app()->request->getParam('date_from_str','');
            $date_to_str = Yii::app()->request->getParam('date_to_str','');
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //pagination criteria
            $c = new CDbCriteria();

            //default time range
            $time_from = 0; //beginning of the times
            $time_to = time()+(60*60*24); //current time + one day

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

            //filtration by date
            $c -> addBetweenCondition('date',$time_from,$time_to);

            //filtration by movement id
            if(!empty($movement_id))
            {
                $c -> addInCondition('id',array($movement_id));
            }
            if(!empty($src_stock_id))
            {
                $c -> addInCondition('src_stock_id',array($src_stock_id));
            }
            if(!empty($trg_stock_id))
            {
                $c -> addInCondition('trg_stock_id',array($trg_stock_id));
            }

            //get all items
            $items = StockMovements::model()->findAll($c);

            //pagination stuff
            $pagination = new CPagerComponent($items,$on_page,$page);

            //render partial
            $this->renderPartial('_ajax_movement_filtering',array('pager' => $pagination));
        }
        else
        {
            throw new CHttpException(404);
        }
    }
}