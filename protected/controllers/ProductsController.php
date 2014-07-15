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
    public function actionCategories()
    {
        //get all categories from database
        $categories = ProductCardCategories::model()->findAll();

        //render list
        $this->render('category_list',array('categories' => $categories));
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
            $form -> validate();

            //if has errors
            if(!$form->hasErrors())
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
                $form -> validate();

                //if has errors
                if(!$form->hasErrors())
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

    /****************************************************************************************************************
     ****************************************** P R O D U C T  C A R D S ********************************************
     ***************************************************************************************************************/

    /**
     * List cards
     */
    public function actionCards()
    {
        //criteria
        $c = new CDbCriteria();

        //get all cards
        $cards = ProductCards::model()->with('category')->findAll($c);
        $categories = ProductCardCategories::model()->findAll();

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

        //if set post form params
        if(isset($_POST['ProductCardForm']))
        {
            //validate all attributes
            $form->attributes = $_POST['ProductCardForm'];
            $form->validate();

            //if no errors
            if(!$form->hasErrors())
            {
                //set params
                $card->attributes = $_POST['ProductCardForm'];
                $card->date_changed = time();
                $card->date_created = time();
                $card->user_modified_by = Yii::app()->user->id;

                //save to db
                $card->save();

                //redirect to list
                $this->redirect('/'.$this->id.'/cards');
            }
        }

        //get all categories
        $categories_arr = ProductCardCategories::getAllAsArray();

        //render form
        $this->render('card_create',array('categories_arr' => $categories_arr, 'card' => $card, 'form_mdl' => $form));
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
        $card = ProductCards::model()->findByPk($id);

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
                $form->validate();

                //if no errors
                if(!$form->hasErrors())
                {
                    //set params
                    $card->attributes = $_POST['ProductCardForm'];
                    $card->date_changed = time();
                    $card->date_created = time();
                    $card->user_modified_by = Yii::app()->user->id;

                    //save to db
                    $card->save();

                    //redirect to list
                    $this->redirect('/'.$this->id.'/cards');
                }
            }

            //get all categories
            $categories_arr = ProductCardCategories::getAllAsArray();

            //render form
            $this->render('card_edit',array('categories_arr' => $categories_arr, 'card' => $card, 'form_mdl' => $form));
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
        $card = ProductCards::model()->with('operationsIns','operationsOuts','productInStocks')->findByPk($id);

        //if found
        if(!empty($card))
        {
            //check for usages - if used somewhere
            if(count($card->operationsIns) > 0 || count($card->operationsOuts) > 0 || $card->productInStocks)
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