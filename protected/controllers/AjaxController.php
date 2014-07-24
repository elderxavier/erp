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
     * Changes status of product by ajax
     * @param null $id
     */
    public function actionChangeProductStatus($id = null)
    {
        /* @var $object ProductCards */

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
     * Renders form by JSON settings (used in purchase_create.php)
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
     * Renders partial-table of operations done in invoice (used in purchase_create.php)
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
     * Prints json-converted array of client-ids and client-names (used in srv_create.php)
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
     * Finds client by name or company name, and prints his ID if found (used in srv_create.php)
     * @param string $name
     * @throws CHttpException
     */
    public function actionCliFi($name = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
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

            //get row by query
            $data=$con->createCommand($sql)->queryRow();

            //if find something
            if(!empty($data))
            {
                //client
                $client = new Clients();
                //set attributes from base to client
                $client -> attributes = $data;
                //render form partial
                $this->renderPartial('_client_form_old_client',array('client' => $client, 'id' => $data['id']));
            }
            //if not find
            else
            {
                //get full name or company name
                count($words) > 1 ? $client_name = $words[0].' '.$words[1] : $client_name = $words[0];

                //render partial
                $this->renderPartial('_client_form_new_client',array('client_name' => $client_name));
            }

        }
        else
        {
            throw new CHttpException(404);
        }
    }

    public function actionCliFiId($id = null)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $sql = "SELECT * FROM clients WHERE id = '".$id."'";
            $con = Yii::app()->db;
            $data = $con->createCommand($sql)->queryRow();

            if($data)
            {
                $client = new Clients();
                $client -> attributes = $data;
                $this->renderPartial('_client_form_old_client',array('client' => $client, 'id' => $data['id']));
            }
            else
            {
                echo "ERROR";
            }
        }
    }


    /**
     * Renders option items of workers found by city for select-box (used in srv_create.php)
     * @param int $city
     * @throws CHttpException
     */
    public function actionWorkers($city = 0)
    {
        /* @var $worker_position Positions */
        /* @var $user Users */

        if(Yii::app()->request->isAjaxRequest)
        {
            //get worker position
            $worker_position = Positions::model()->with('users')->findByAttributes(array('name' => 'Worker'));

            //if city selected
            if($city != 'ALL')
            {
                //users by city and position
                $users = Users::model()->findAllByAttributes(array('city_id' => $city, 'position_id' => $worker_position->id));
            }
            //if selected all cities
            else
            {
                //get all workers
                $users = $worker_position->users;
            }

            //render options for select box
            $this->renderPartial('_workers_select_item', array('workers' => $users));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Delete file item from db by ajax
     * @param int $id
     */
    public function actionDelFile($id = 0)
    {
        /* @var $file ProductFiles */

        //find file
        $file = ProductFiles::model()->findByPk($id);

        //if found
        if($file)
        {
            //delete file if exist
            if($file->filename != '' && file_exists('uploaded/product_file/'.$file->filename))
            {
                unlink('uploaded/product_file/'.$file->filename);
            }

            //delete record from db
            $file->delete();

            //print success status
            echo "SUCCESS";
        }
        //if not found
        else
        {
            //print fail status
            echo "FAILED";
        }
    }

}
?>