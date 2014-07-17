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

}
?>