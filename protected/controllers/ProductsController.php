<?php

class ProductsController extends Controller
{
    /**
     * Returns sub-menu settings
     * @return array
     */
    public function GetSubMenu()
    {
        $arr = array(
            'categories' => array('action' => 'categories','visible' => $this->rights['categories_see'] ? 1 : 0 , 'class' => 'list-products'),
            'add category' => array('action' => 'addcat', 'visible' => $this->rights['categories_add'] ? 1 : 0, 'class' => 'create-product'),
            'product cards' => array('action' => 'cards', 'visible' => $this->rights['products_see'] ? 1 : 0, 'class' => 'list-products'),
            'add product card' => array('action' => 'addcard', 'visible' => $this->rights['products_add'] ? 1 : 0, 'class' => 'create-product'),
        );

        return $arr;
    }

    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->actionCategories();
    }

    /****************************************************************************************************************
     ***************************************** C A T E G O R I E S **************************************************
     ***************************************************************************************************************/


    /**
     * List all categories
     */
    public function actionCategories($page = 1, $on_page = 3)
    {
        //get all categories from database
        $categories = ProductCardCategories::model()->findAll();

        //pagination object with all elements on this page
        $pager = new CPagerComponent($categories,$on_page,$page);

        //render list
        $this->render('category_list',array('pager' => $pager));
    }


    /**
     * Add category
     */
    public function actionAddCat()
    {
        //create form-validator object
        $form = new ProductCategoryForm();
        $category = new ProductCardCategories();

        //if isset right post param
        if($_POST['ProductCategoryForm'])
        {
            //form model
            $form -> attributes = $_POST['ProductCategoryForm'];

            //if has errors
            if($form -> validate())
            {
                //set attributes
                $category -> attributes = $_POST['ProductCategoryForm'];
                $category -> date_created = time();
                $category -> date_changed = time();
                $category -> user_modified_by = Yii::app()->user->id;

                //save
                $category -> save();

                //redirect to list
                $this->redirect('/'.$this->id.'/categories');
            }
        }

        //render form
        $this->render('category_create', array('category' => $category, 'form_mdl' => $form));
    }


    /**
     * Edit category
     * @param null $id
     * @throws CHttpException
     */
    public function actionEditCat($id = null)
    {
        /* @var $category ProductCardCategories */

        //find in base
        $category = ProductCardCategories::model()->findByPk($id);

        //if not found - 404 error
        if(!empty($category))
        {
            //create form-validator object
            $form = new ProductCategoryForm();

            //if isset right post param
            if($_POST['ProductCategoryForm'])
            {
                //form model
                $form -> attributes = $_POST['ProductCategoryForm'];

                //if has errors
                if($form -> validate())
                {
                    //set attributes
                    $category -> attributes = $_POST['ProductCategoryForm'];
                    $category -> date_changed = time();
                    $category -> user_modified_by = Yii::app()->user->id;

                    //update
                    $category -> update();

                    //redirect to list
                    $this->redirect('/'.$this->id.'/categories');
                }
            }

            //render form
            $this->render('category_edit', array('category' => $category, 'form_mdl' => $form));
        }
        else
        {
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }

    /**
     * Delete category
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteCat($id = null)
    {
        /* @var $category ProductCardCategories */

        //find in base
        $category = ProductCardCategories::model()->findByPk($id);

        //if not found - 404 error
        if(!empty($category))
        {
            //check if this category used in product cards
            if(count($category->productCards) > 0)
            {
                //render restrict message
                $this->render('restricts');
            }
            //if not used
            else
            {
                //delete category
                $category->delete();

                //redirect to list
                $this->redirect('/'.$this->id.'/categories');
            }
        }
        else
        {
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }

    /***************************************** A J A X  S E C T I O N ***********************************************/

    public function actionFilterCategories()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //filter param
            $name = Yii::app()->request->getParam('name','');

            //pagination params
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //filter criteria
            $c = new CDbCriteria();

            if(!empty($name))
            {
                $c -> addCondition("name LIKE '%".$name."%'");
            }

            $items = ProductCardCategories::model()->findAll($c);
            $pager = new CPagerComponent($items,$on_page,$page);

            $this->renderPartial('_categories_filtered',array('pager' => $pager));
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /****************************************************************************************************************
     ****************************************** P R O D U C T  C A R D S ********************************************
     ***************************************************************************************************************/

    /**
     * List cards
     */
    public function actionCards()
    {
        //get all cards
        $cards = ProductCards::model()->with('category')->findAll();
        $categories = ProductCardCategories::model()->getAllAsArray();
        //render list
        $this->render('card_list',array('cards' => $cards, 'categories' => $categories));
    }


    /**
     * Add card
     */
    public function actionAddCard()
    {
        //create form-validator-object and card object
        $form = new ProductCardForm();
        $card = new ProductCards();
        $measure_units = MeasureUnits::model()->findAllAsArray();
        $size_units = SizeUnits::model()->findAllAsArray();

        //if set post form params
        if(isset($_POST['ProductCardForm']))
        {
            //validate all attributes
            $form->attributes = $_POST['ProductCardForm'];

            //if no errors
            if($form->validate())
            {
                //set params
                $card->attributes = $_POST['ProductCardForm'];
                $card->date_changed = time();
                $card->date_created = time();
                $card->user_modified_by = Yii::app()->user->id;

                //save to db
                $card->save();

                //get array of files
                $files = CUploadedFile::getInstances($form,'files');

                //save files
                ProductFiles::model()->saveFiles($files,$card->id);

                //redirect to list
                $this->redirect('/'.$this->id.'/cards');
            }
        }

        //get all categories
        $categories_arr = ProductCardCategories::model()->getAllAsArray();

        //render form
        $this->render('card_create',array('categories_arr' => $categories_arr, 'card' => $card, 'm_units' => $measure_units, 's_units' => $size_units, 'form_mdl' => $form));
    }


    /**
     * Edit card
     * @param null $id
     * @throws CHttpException
     */
    public function actionEditCard($id = null)
    {
        /* @var $card ProductCards */

        //try find in base
        $card = ProductCards::model()->with('productFiles')->findByPk($id);

        $measure_units = MeasureUnits::model()->findAllAsArray();
        $size_units = SizeUnits::model()->findAllAsArray();

        //if found
        if(!empty($card))
        {
            //create form-validator-object and card object
            $form = new ProductCardForm();

            //set current card-id to validator, to avoid unique-check-error when updating
            $form -> current_card_id = $card->id;

            //if set post form params
            if(isset($_POST['ProductCardForm']))
            {
                //validate all attributes
                $form->attributes = $_POST['ProductCardForm'];

                //if no errors
                if($form->validate())
                {
                    //set params
                    $card->attributes = $_POST['ProductCardForm'];
                    $card->date_changed = time();
                    $card->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $card->save();

                    //get array of files
                    $files = CUploadedFile::getInstances($form,'files');

                    //save files
                    ProductFiles::model()->saveFiles($files,$card->id);

                    //redirect to list
                    $this->redirect('/'.$this->id.'/cards');
                }
            }

            //get all categories
            $categories_arr = ProductCardCategories::model()->getAllAsArray();

            //render form
            $this->render('card_edit',array('categories_arr' => $categories_arr, 'card' => $card, 'm_units' => $measure_units, 's_units' => $size_units, 'form_mdl' => $form));
        }
        //if not found
        else
        {
            //throw exception
            throw new CHttpException(404,$this->labels['item not found in base']);
        }
    }


    /**
     * Delete card
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteCard($id = null)
    {
        /* @var $card ProductCards */

        //try find in base
        $card = ProductCards::model()->with('OperationsInItemss','operationsOuts','productInStocks')->findByPk($id);

        //if found
        if(!empty($card))
        {
            //check for usages - if used somewhere
            if(count($card->operationsInItems) > 0 || count($card->operationsOutItems) > 0 || $card->productInStocks)
            {
                //render restricts
                $this->render('restricts');
            }
            else
            {
                //delete card
                $card->delete();
                //redirect to list
                $this->redirect('/'.$this->id.'/cards');
            }
        }
        //if not found
        else
        {
            throw new CHttpException(404,$this->labels['item not found in base']);
        }

    }

}