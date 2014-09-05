<?php

class StockController extends Controller
{
    /**
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'products' => array('action' => 'list','visible' => $this->rights['stock_see'] ? 1 : 0 , 'class' => 'list-products'),
            'movements' => array('action' => 'movements', 'visible' => $this->rights['stock_see'] ? 1 : 0, 'class' => 'list-products'),
            'move products' => array('action' => 'move', 'visible' => $this->rights['stock_see'] ? 1 : 0, 'class' => 'create-product')
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
     * List all products in stock
     * @param int $page
     */
    public function actionList($page = 1)
    {
        $cities = UserCities::model()->findAllAsArray();
        $units = MeasureUnits::model()->findAllAsArray();

        $c = new CDbCriteria();
        $c -> limit = $this->on_one_page;
        $c -> offset = ($this->on_one_page * ($page - 1));

        $count = ProductInStock::model()->count();
        $pages = $this->calculatePageCount($count);

        $productsObj = ProductInStock::model()->with('stock','stock.location','productCard')->findAll($c);
        $this->render('list',array('products' => $productsObj, 'cities' => $cities, 'pages' => $pages, 'current_page' => $page, 'units' => $units));
    }//actionList

    /**
     * List all movements
     * @param int $page
     */
    public function actionMovements($page = 1)
    {
        $c = new CDbCriteria();
        $c -> limit = $this->on_one_page;
        $c -> offset = ($this->on_one_page * ($page - 1));

        $count = ProductInStock::model()->count();
        $pages = $this->calculatePageCount($count);
        $stock = Stocks::model()->getAsArrayPairs();

        $movements = StockMovements::model()->with('stockMovementItems','stockMovementStages','status','srcStock','trgStock')->findAll($c);
        $this->render('list_movements',array('movements' => $movements, 'pages' => $pages, 'page' => $page, 'stocks' => $stock));
    }//actionMovements


    /**
     * Renders movement form
     */
    public function actionMove()
    {
        $stocks = Stocks::model()->findAll();
        $this->render('add_movement',array('stocks' => $stocks));
    }//actionMove


    /**
     * Finish movement - write to base
     */
    public function actionMoveFinish()
    {
        Debug::out($_POST);
        exit();
    }//MoveFinish


    /****************************************** A J A X  S E C T I O N ************************************************/

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

            $c = new CDbCriteria();
            $c = $this->addAllFilterCriterion($c,$prod_name,$prod_code,$stock_loc_id,$units);

            $c -> limit = $this->on_one_page;
            $c -> offset = ($this->on_one_page * ($page - 1));

            $items = ProductInStock::model()->findAll($c);

            $this->renderPartial('_ajax_table_filtering',array('items' => $items));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilter


    /**
     * Renders pagination block
     */
    public function actionAjaxPages()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $prod_name = Yii::app()->request->getParam('name','');
            $prod_code = Yii::app()->request->getParam('code','');
            $stock_loc_id = Yii::app()->request->getParam('location','');
            $units = Yii::app()->request->getParam('units','');
            $page = Yii::app()->request->getParam('page',1);

            //store all filter-params to array
            $filter_params = array(
                'name' => $prod_name,
                'code' => $prod_code,
                'location' => $stock_loc_id,
                'units' => $units,
                'page' => $page
            );

            $c = new CDbCriteria();
            $c = $this->addAllFilterCriterion($c,$prod_name,$prod_code,$stock_loc_id,$units);

            $count = ProductInStock::model()->count($c);
            $pages_count = $this->calculatePageCount($count);

            $this->renderPartial('_ajax_pages',array('pages' => $pages_count, 'current' => $page, 'filters' => $filter_params));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Updates criteria by filter params
     * @param CDbCriteria $c
     * @param string $product_name
     * @param string $product_code
     * @param int $stock_location_id
     * @param string $units
     * @return CDbCriteria
     */
    public function addAllFilterCriterion($c,$product_name,$product_code,$stock_location_id,$units)
    {
        /* @var $c CDbCriteria */
        /* @var $card ProductCards */

        $products_ids = array(); //ids of product to search by
        $stock_ids = array(); //ids of stocks to search by

        //if product name set
        if(!empty($product_name) || !empty($product_code))
        {
            //get all product-card rows (by SQL) from base by product name
            $products_with_similar_name_code_rows = ProductCards::model()->findAllByNameOrCode($product_name,$product_code);

            //if something found by name
            if(!empty($products_with_similar_name_code_rows))
            {
                //add all ID's to array if not already added
                foreach($products_with_similar_name_code_rows as $row)
                {
                    if(!in_array($row['id'],$products_ids)) $products_ids[] = $row['id'];
                }
            }
        }

        //if measure units set
        if(!empty($units))
        {
            //find all product-cards by measure units
            $products = ProductCards::model()->findAllByAttributes(array('measure_units_id' => $units));

            //if found by units
            if(!empty($products))
            {
                //add all ID's to array if not already added
                foreach($products as $card)
                {
                    if(!in_array($card->id,$products_ids)) $products_ids[] = $card->id;
                }
            }
        }

        //if stock location set
        if(!empty($stock_location_id))
        {
            /* @var $city UserCities */

            //get city by id
            $city = UserCities::model()->findByPk($stock_location_id);

            //if found
            if(!empty($city))
            {
                //get all stock of this city, and add their id to search-criteria array
                foreach($city->stocks as $stock)
                {
                    $stock_ids[] = $stock->id;
                }
            }
        }

        //add ID's of product cards to conditions (if should search by name, code or units)
        if(!empty($product_name) || !empty($product_code) || !empty($units))
        {
            $c -> addInCondition('product_card_id',$products_ids);
        }
        //add ID's of stocks to condition (if should search by stock location)
        if(!empty($stock_location_id))
        {
            $c -> addInCondition('stock_id',$stock_ids);
        }

        return $c;
    }//addAllFilterCriterion
};