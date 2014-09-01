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

    /*
    public function actionViewInvoiceIn($id = null)
    {
        //get all operations by invoice id
        $operations_in = OperationsInItems::model()->findAllByAttributes(array('operation_id' => $id));

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
    */


    /**
     * Prints json-converted array of client-ids and client-names (used for auto-complete)
     * @param int $term
     * @param int $type
     * @throws CHttpException
     */
    public function actionClients($term=null,$type=null)
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
            //delete file
            @unlink('uploaded/product_file/'.$file->filename);

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


    /**
     * Renders service-resolution info
     * @param null $id
     * @throws CHttpException
     */
    public function actionResolutionView($id = null)
    {
        /* @var $resolution ServiceResolutions */

        //if ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //if found
            if($resolution = ServiceResolutions::model()->findByPk((int)$id))
            {
                //render partial
                $this->renderPartial('_resolution_view',array('resolution' => $resolution));
            }
            //if not found
            else
            {
                //error message
                echo $this->messages['Information not found'];
            }
        }
        //if not ajax
        else
        {
            //exception
            throw new CHttpException(404);
        }
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

        }else{
            throw new CHttpException(404);
        }
    }//actionSellers


    public function actionSellfilter()
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

    public function actionSellinfo($id = null)
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
    }//custInfo


    /**
     * Renders table of products
     * @param string $name
     * @param string $code
     */
    public function actionFindProductsModal($name='',$code='')
    {
        $rows = ProductCards::model()->findAllByNameOrCode($name,$code);
        $this->renderPartial('_find_prod_modal',array('rows' => $rows));
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

    public function actionFilterByStockCodeAndName($name = '',$code = '',$stock = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = ProductCards::model()->findAllByNameOrCodeAndStock($name,$code,$stock);
            $this->renderPartial('_filtered_for_sales',array('items' => $result));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

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

    public function actionCustFilter()
    {
        $request = Yii::app()->request;

        if($request->isAjaxRequest){

            $name = $request->getPost('name');
            $type = $request->getPost('type');

            //get next-step controller and action
            $next_con= $request->getPost('nc','services');
            $next_act = $request->getPost('na','continue');

            $data = Clients::model()->getClients($name,$type);

            if(!empty($data)){
                echo $this->renderPartial('_filterTable',array('data'=>$data,'type' => $type,'next_c' => $next_con, 'next_a' => $next_act),true);
            }else{
                echo $this->renderPartial('_emptyTable',array(),true);
            }

        }else{
            throw new CHttpException(404);
        }
    }// custFilter

    public function actionCustinfo($id = null,$nc = 'services',$na = 'continue')
    {
        $id = (int)$id;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $data = Clients::model()->findByPk($id);
            $modal = $this->renderPartial('_customer_info_modal',array('client' => $data, 'next_controller' => $nc, 'next_action' => $na),true);
            echo $modal;
        }else{
            throw new CHttpException(404);
        }
    }//custInfo


}
?>