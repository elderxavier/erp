<?php

class ProductsController extends Controller
{
    //R E T U R N S  S U B M E N U  F O R  T H I S  C O N T R O L L E R
    public function GetSubMenu()
    {
        /* @var $user_rights UserRights */

        $user_rights = Yii::app()->user->GetState('rights');

        $arr = array(
            'add category' => array('action' => 'addcat', 'visible' => $this->rights['categories_add'] ? 1 : 0, 'class' => 'create-product'),
            'categories' => array('action' => 'categories','visible' => $this->rights['categories_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add product card' => array('action' => 'addcard', 'visible' => $this->rights['products_add'] ? 1 : 0, 'class' => 'create-product'),
            'product cards' => array('action' => 'cards', 'visible' => $this->rights['products_see'] ? 1 : 0, 'class' => 'list-products'),
        );

        return $arr;
    }

    //I N D E X
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id.'/categories'));
    }

    //L I S T  C A T E G O R I E S
    public function actionCategories()
    {
        //get all categories from database
        $categories = ProductCardCategories::model()->findAll();

        //actions for every record
        $actions = array(
            'delete' => array('controller' => Yii::app()->controller->id, 'action' => 'deletecat', 'class' => 'action-lnk' , 'visible' => $this->rights['categories_delete'] ? 1 : 0),
            'edit' => array('controller' => Yii::app()->controller->id, 'action' => 'editcat', 'class' => 'action-lnk', 'visible' => $this->rights['categories_edit'] ? 1 : 0),
        );

        //render list
        $this->render('list_categories',array('categories' => $categories, 'table_actions' => $actions));
    }

    //E D I T  C A T E G O R Y
    public function actionEditCat()
    {
        //get id from request
        $id = Yii::app()->request->getParam('id',null);

        //find in base
        $category = ProductCardCategories::model()->findByPk($id);

        //if not found - 404 error
        if(empty($category)){throw new CHttpException(404,Label::Get('item not found in base'));}

        //render form
        $this->render('edit_category',array('category' => $category));
    }

    //A D D  C A T E G O R Y
    public function actionAddCat()
    {
        //render form
        $this->render('edit_category');
    }

    //D E L E T E  C A T E G O R Y
    public function actionDeleteCat()
    {
        /* @var $category ProductCardCategories */

        //array of restrict-reasons
        $restricts = array();

        //get id from request
        $id = Yii::app()->request->getParam('id',null);

        //find in base
        $category = ProductCardCategories::model()->findByPk($id);

        //if not found - 404 error
        if(empty($category)){throw new CHttpException(404,Label::Get('item not found in base'));}

        //check if this category used in product cards
        if(count($category->productCards) > 0){array_push($restricts,Label::Get('this item used in').' '.Label::Get('product cards')); }

        //if have no restricts
        if(empty($restricts))
        {
            //delete category
            $category->delete();

            //redirect to list
            $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id.'/categories'));
        }

        //restrict
        else
        {
            $this->render('restricts',array('restricts' => $restricts));
        }
    }


    //U P D A T E  C A T E G O R Y
    public function actionUpdateCat()
    {
        //get id from request
        $id = Yii::app()->request->getParam('id',null);
        $name = Yii::app()->request->getParam('category_name','');
        $remark = Yii::app()->request->getParam('remark','');

        //find category
        $category = ProductCardCategories::model()->findByPk($id);

        //if found nothing - create new
        if(empty($category)){$category = new ProductCardCategories();}

        //set main params
        $category->name = $name;
        $category->remark = $remark;
        $category->status = 1;
        $category->date_changed = time();

        //if created new object
        if($category->isNewRecord)
        {
            //creation time
            $category->date_created = time();

            //update time
            $category->save();
        }
        //if update old object
        else
        {
            //update
            $category->update();
        }

        //redirect to list
        $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id.'/categories'));
    }

}