<?php
class AjaxController extends Controller {
 
    
    public function actionProduct(){
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $category_id = $request->getPost('category');
            if(!empty($category_id)){
                $objProds = ProductCards::model()->with('category')->findAllByAttributes(array('category_id'=>$category_id));
                
                $table = $this->renderPartial('_table',array('objProds'=>$objProds),true);
            } 

            echo $table;
        }else{
            throw new CHttpException(404);
        }
        
    }

    /**
     * Renders form by JSON settings
     * @param null $data
     * @throws CHttpException
     */
    public function actionBuyForm($data = null)
    {
        //if ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //convert to PHP array
            $settings = json_decode($data,true);

            //get supplier id, stock id, and array of products
            $supplier_id = $settings['supplier'];
            $stock_id = $settings['stock'];
            $products_inf_array = $settings['products'];
            $signer_name = $settings['signer'];
            $invoice_code = $settings['inv_code'];

            //try find supplier in db
            $supplier = Suppliers::model()->findByPk($supplier_id);
            $stock = Stocks::model()->findByPk($stock_id);

            //if found
            if($supplier != null && $stock != null)
            {
                //declare array of product-param blocks
                $product_params = array();

                //for each product-info block in array
                foreach($products_inf_array as $index => $prod_info)
                {
                    /* @var $card ProductCards */

                    //try find product card by id
                    $card = ProductCards::model()->findByPk($prod_info['id']);

                    //if found and quantity more than zero
                    if($card && $prod_info['qnt'] > 0)
                    {
                        $product_params[] = array(
                            'obj' => $card,
                            'quantity' => $prod_info['qnt'],
                            'price' => $prod_info['price']
                        );
                    }
                }

                //render form with all data
                $this->renderPartial('_form_buy',array('supplier' => $supplier, 'stock' => $stock, 'product_params' => $product_params, 'signer' => $signer_name, 'invoice_code' => $invoice_code));
            }
            //if not found
            else
            {
                //TODO: render special error message for modal form
                exit('error');
            }
        }
        //if not ajax
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Changes status of product by ajax
     * @param null $id
     */
    public function actionChangeProductStatus($id = null)
    {
        //if this is ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //try find
            $object =  ProductCards::model()->findByPk($id);

            //if found
            if($object)
            {
                if($object->status == 1){
                    $object->status = 0;
                }else{
                    $object->status = 1;
                }
                //update
                $object->update();

                //out success message
                exit('SUCCESS');
            }
            //if not found
            else
            {
                //out fail message
                exit('FAILED');
            }
        }
    }

    /**
     * Renders partial-table of operations done in invoice
     * @param null $id
     */
    public function actionViewInvoiceIn($id = null)
    {
        //get all operations by invoice id
        $operations_in = OperationsIn::model()->findAllByAttributes(array('invoice_id' => $id));

        //if find something
        if(!empty($operations_in))
        {
            $this->renderPartial('_in_operations',array('ops' => $operations_in));
        }
        //if find nothing
        else
        {
            $this->renderPartial('_in_operations',array('ops' => array()));
        }
    }


    /**
     * Prints json-converted array of client-ids and client-names
     * @param string $start
     * @throws CHttpException
     */
    public function actionClients($start = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //declare empty array
            $result = array();

            //sql statement
            $sql = "SELECT * FROM clients WHERE company_name LIKE '".$start."%' OR `name` LIKE '".$start."%'";

            //connection
            $con = Yii::app()->db;

            //get all data by query
            $data=$con->createCommand($sql)->queryAll();

            //foreach row
            foreach($data as $row)
            {
                //add to result array
                $result[] = array('label' => $row['type'] == 1 ? $row['company_name'] : $row['name'].' '.$row['surname'], 'id' => $row['id']);
            }

            //print encoded to json array
            echo json_encode($result);
        }
        else
        {
            throw new CHttpException(404);
        }

    }


    /**
     * Finds client-id by name or company name, and prints if found
     * @param string $name
     * @throws CHttpException
     */
    public function actionCliFi($name = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //not found by default
            $result = 'NOT_FOUND';

            //remove all connecting symbols, replace them with spaces
            $name = str_replace("%20"," ",$name);
            $name = str_replace("+"," ",$name);

            //get array of separated-by-spaces words
            $words = explode(" ",$name);

            //if complex name (name and surname expecting)
            if(count($words) > 1)
            {
                //sql statement
                $sql = "SELECT * FROM clients WHERE company_name = '".$name."' OR ((name LIKE '".$words[0]."') AND (surname LIKE '".$words[1]."'))";
            }
            //if simple name (one word)
            else
            {
                $sql = "SELECT * FROM clients WHERE company_name = '".$name."' OR name LIKE '".$name."%'";
            }


            //connection
            $con = Yii::app()->db;

            //get all data by query
            $data=$con->createCommand($sql)->queryAll();

            //if find something
            if(!empty($data))
            {
                $result = $data[0]['id'];
            }

            echo $result;
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    public function actionWorkers($city = 0)
    {
        /* @var $worker_position Positions */
        /* @var $user Users */

        $worker_position = Positions::model()->findByAttributes(array('name' => 'Worker'));
        $users = Users::model()->findAllByAttributes(array('city_id' => $city, 'position_id' => $worker_position->id));

        //TODO:render partial
    }

}
?>