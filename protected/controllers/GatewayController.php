<?php

class GatewayController extends Controller {

    /**
     * Returns JSON-array of product-cards
     */
    public function actionCards()
    {
        /* @var $card ProductCards */

        //empty array
        $result = array();

        //get all cards
        $cards = ProductCards::model()->findAll();

        //foreach card
        foreach($cards as $card)
        {
            //add array
            $result[] = array('id' => $card->id, 'name' => $card->product_name, 'code' => $card->product_code);
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