<?php

class GatewayController extends Controller {

    /**
     * Returns JSON-array of product-cards
     */
    public function actionCards($codename = null)
    {
        //declare empty array
        $result = array();

        if($codename)
        {
            //sql statement
            $sql = "SELECT * FROM product_cards WHERE product_code LIKE '%".$codename."%' OR `product_name` LIKE '%".$codename."%'";
        }
        else
        {
            $sql = "SELECT * FROM product_cards";
        }


        //connection
        $con = Yii::app()->db;

        //get all data by query
        $data=$con->createCommand($sql)->queryAll();

        //foreach row
        foreach($data as $row)
        {
            //add to result array
            $result[] = array('id' => $row['id'],'name' => $row['product_name'],'code' => $row['product_code']);
        }

        echo json_encode($result);
    }

    /**
     * /gateway/ops/from/1405692681/to/2000000000/id/2
     * /gateway/ops?from=1405692681&to=2000000000&id=2
     * Returns array of operations from one date to another date by product id
     * @param $from
     * @param $to
     * @param $id
     */
    public function actionOps($from,$to,$id)
    {

        /* @var $operation OperationsOut */

        //declare array of results
        $results = array();

        //create criteria
        $c = new CDbCriteria();

        //set conditions
        $c -> addInCondition('product_card_id',array($id));
        $c -> addBetweenCondition('date',$from,$to);

        //get all by criteria
        $operations = OperationsIn::model()->findAll($c);

        //foreach operation
        foreach($operations as $operation)
        {
            $results[]= $operation->attributes;
        }

        //return
        echo json_encode($results);
    }

}