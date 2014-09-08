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
     * @throws CHttpException
     */
    public function actionMoveFinish()
    {
        if(isset($_POST['MovementForm']) && !empty($_POST['MovementForm']))
        {
            //get form
            $form = $_POST['MovementForm'];

            //get values
            $products = isset($form['products']) ? $form['products'] : array();
            $src_stock_id = isset($form['src_stock']) ? $form['src_stock'] : 0;
            $trg_stock_id = isset($form['trg_stock']) ? $form['trg_stock'] : 0;
            $car_number = isset($form['car_number']) ? $form['car_number'] : '';
            $car_brand =  isset($form['car_brand']) ? $form['car_brand'] : '';
            $generate_pdf = isset($form['generate_pdf']) ? true : false;

            //new movement
            $movement = new StockMovements();
            $movement -> date = time(); //current time
            $movement -> status_id = 1; // 1 - On the way, 2 - Delivered, 3 - Canceled, 4 - Stopped, 5 - Returned
            $movement -> src_stock_id = $src_stock_id; //from stock
            $movement -> trg_stock_id = $trg_stock_id; //to stock
            $movement -> car_number = $car_number; //car number
            $movement -> car_brand = $car_brand; //car brand
            $movement -> save(); //save

            //for-each products
            foreach($products as $id => $qnt)
            {
                /* @var $card ProductCards */
                $card = ProductCards::model()->findByPk($id);

                //new movement item
                $item = new StockMovementItems();
                $item -> movement_id = $movement->id; //movement ID
                $item -> product_card_id = $id; //product card
                $item -> qnt = $qnt; //quantity
                $item -> item_weight = $card->weight; //weight of one item (gross)
                $item -> src_stock_id = $movement->src_stock_id; //source stock (additional field, not related, just for report-simplifying)
                $item -> trg_stock_id = $movement->trg_stock_id; //target stock (additional field, not related, just for report-simplifying)
                $item -> in_src_stock_after_movement = 0; //zero - because not moved yet
                $item -> in_trg_stock_after_movement = 0; //zero - because not moved yet
                $item -> save(); //cave
            }

            //new movement stage (as resolution in help-desk)
            $stage = new StockMovementStages();
            $stage -> movement_id = $movement->id; //movement ID
            $stage -> movement_status_id = $movement->status->id; // current status of movement
            $stage -> user_operator_id = Yii::app()->user->id; //operator(current user) ID
            $stage -> operator_name = Yii::app()->user->getState('name').' '.Yii::app()->user->getState('surname'); //operator name (not necessary)
            $stage -> time = time(); //current time
            $stage -> remark = '-'; //empty remark by default

            //redirect to movement list
            $this->redirect(Yii::app()->createUrl('/stock/movements'));
        }
        else
        {
            throw new CHttpException(404);
        }

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

            //criteria for pagination
            $c = Pagination::getFilterCriteria(3,$page);

            //conditions - null by default
            $product_con_arr = null;
            $measure_con_arr = null;
            $location_con_arr = null;

            //if have product name and product code
            if(!empty($prod_name) && !empty($prod_code))
            {
                $product_con_arr = array('condition'=>'productCard.product_name LIKE "%'.$prod_name.'%" AND productCard.product_code LIKE "%'.$prod_code.'%"');
            }
            //if have just product name
            elseif(!empty($prod_name))
            {
                $product_con_arr = array('condition'=>'productCard.product_name LIKE "%'.$prod_name.'%"');
            }
            //if have just product code
            elseif(!empty($prod_code))
            {
                $product_con_arr = array('condition'=>'productCard.product_code LIKE "%'.$prod_code.'%"');
            }

            //if have units
            if(!empty($units))
            {
                $measure_con_arr = array('condition'=>'measureUnits.id= '.$units);
            }

            //if have location
            if(!empty($stock_loc_id))
            {
                $location_con_arr = array('condition'=>'location.id= '.$stock_loc_id);
            }


            //get all items by conditions and limit them by criteria
            $items = ProductInStock::model()->with(array(
                'productCard' => $product_con_arr,
                'productCard.measureUnits' => $measure_con_arr,
                'stock',
                'stock.location' => $location_con_arr))->findAll($c);

            //count all filtered items
            $count = ProductInStock::model()->with(array(
                'productCard' => $product_con_arr,
                'productCard.measureUnits' => $measure_con_arr,
                'stock',
                'stock.location' => $location_con_arr))->count();

            //calculate count of pages
            $pages = Pagination::calcPagesCount($count,3);

            //render table and pages
            $this->renderPartial('_ajax_table_filtering',array('items' => $items, 'pages' => $pages, 'current_page' => $page));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilter
};