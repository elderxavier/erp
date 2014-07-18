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

}
?>