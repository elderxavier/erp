<?php

class AjaxController extends Controller
{
    /**
     * Auto-complete for categories
     * @param string $term
     * @throws CHttpException
     */
    public function actionAutoCompleteCategories($term = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $arr = ProductCardCategories::model()->findAllByName($term);
            $arr = array_slice($arr,0,5);
            echo json_encode($arr);
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionAutoCompleteCategories(


    /**
     * Filtration for categories
     * @throws CHttpException
     */
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
    }//actionFilterCategories


    /**
     * @throws CHttpException
     */
    public function actionFilterProducts()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            //pagination params
            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            //filter params
            $code = Yii::app()->request->getParam('code','');
            $name = Yii::app()->request->getParam('name','');
            $category_id = Yii::app()->request->getParam('category_id','');
            $measure_id = Yii::app()->request->getParam('measure_id','');
            $status = Yii::app()->request->getParam('status','');

            //criteria for filtration
            $c = new CDbCriteria();

            if(!empty($code))
            {
                $c -> addCondition("product_code LIKE '%".$code."%'");
            }

            if(!empty($name))
            {
                $c -> addCondition("product_name LIKE '%".$name."%'");
            }

            if(!empty($category_id))
            {
                $c -> addInCondition('category_id',array($category_id));
            }

            if(!empty($measure_id))
            {
                $c -> addInCondition('measure_units_id',array($measure_id));
            }

            if($status != '')
            {
                $c -> addInCondition('status',array($status));
            }

            //all filtered items
            $cards = ProductCards::model()->findAll($c);

            //get all for this page
            $pager = new CPagerComponent($cards,$on_page,$page);

            //render table
            $this->renderPartial('_cards_filtered',array('pager' => $pager));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilterProducts

    /**
     * Auto-complete for product's input
     * @param string $name
     * @param string $code
     * @throws CHttpException
     */
    public function actionAutoCompleteProducts($name = '',$code = '')
    {
        //if this is ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            $arr = ProductCards::model()->findAllByNameOrCode($name,$code,true);
            $arr = array_slice($arr,0,5);
            echo json_encode($arr);
        }
        //if not ajax
        else
        {
            throw new CHttpException(404);
        }
    }//actionAutoCompleteProducts

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
     * Renders filtered table of clients
     */
    public function actionRenderFilteredPartForLetters()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $client_name = YiiBase::app()->request->getParam('name','');
            $client_code = YiiBase::app()->request->getParam('code','');

            $clients = Clients::model()->findClientsByNameAndCode($client_name,$client_code,false);
            $this->renderPartial('_filtered_client_part_for_letters',array('clients' => $clients));
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Auto-complete for filtration
     * @param string $name
     * @param string $code
     * @throws CHttpException
     */
    public function actionAutoCompleteForFiltration($name = '', $code = '')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $arr = Clients::model()->findClientsByNameAndCode($name,$code,true);
            $arr = array_slice($arr,0,5);
            echo json_encode($arr);
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Loads template from DB for text-area
     * @param null $id
     * @throws CHttpException
     */
    public function actionLoadTemplate($id = null)
    {
        /* @var $template MailTemplates */

        if(Yii::app()->request->isAjaxRequest)
        {
            $template = MailTemplates::model()->findByPk($id);
            if(!empty($template))
            {
                echo $template->content;
            }
            else
            {
                echo $this->labels['error'];
            }
        }
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Renders created letter-form for modal window
     * @throws CHttpException
     */
    public function actionCreateLetter()
    {
        /* @var $recipients Clients[]*/
        /* @var $files ProductFiles[] */
        /* @var $product ProductCards */


        if(Yii::app()->request->isAjaxRequest)
        {
            //get params from post
            $recipients_ids = Yii::app()->request->getParam('recipients',array());
            $files_ids = Yii::app()->request->getParam('files',array());
            $product_id = Yii::app()->request->getParam('product_id');
            $text = Yii::app()->request->getParam('text');

            //create footer
            $footer_template = "\n\n\n\n\n\n";
            $footer_template .= $this->labels['sincerely, %full_name%, %position% of %company_name% company'];

            $footer_template = str_replace('%full_name%',Yii::app()->user->getState('name').' '.Yii::app()->user->getState('surname'),$footer_template);
            $footer_template = str_replace('%position%',Yii::app()->user->getState('position'), $footer_template);
            $footer_template = str_replace('%company_name%','INLUX', $footer_template);

            //add footer
            $text.=$footer_template;

            //empty arrays
            $recipients = array();
            $files = array();

            //if not empty recipient id's
            if(!empty($recipients_ids))
            {
                //find em all
                $recipients = Clients::model()->findAllByPk($recipients_ids);
            }

            //if not empty file id's
            if(!empty($files_ids))
            {
                //find em all
                $files = ProductFiles::model()->findAllByPk($files_ids);
            }

            //render partial
            $this->renderPartial('_generated_letter',array('recipients' => $recipients, 'files' => $files, 'text' => $text));
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Sends letter to recipients
     */
    public function actionSendLetter()
    {
        /* @var $recipients Clients[]*/
        /* @var $files ProductFiles[] */
        /* @var $product ProductCards */

        //including swift mailer
        spl_autoload_unregister(array('YiiBase','autoload'));
        Yii::import('application.extensions.swift.swift_required', true);
        spl_autoload_register(array('YiiBase','autoload'));

        //get params from post
        $recipients_ids = Yii::app()->request->getParam('recipients',array());
        $files_ids = Yii::app()->request->getParam('files',array());
        $text = Yii::app()->request->getParam('text-field');

        //empty arrays
        $recipients = array();
        $files = array();

        //if not empty recipient id's
        if(!empty($recipients_ids))
        {
            //find em all
            $recipients = Clients::model()->findAllByPk($recipients_ids);
        }

        //if not empty file id's
        if(!empty($files_ids))
        {
            //find em all
            $files = ProductFiles::model()->findAllByPk($files_ids);
        }

        //create array of emails
        $array_emails = array();
        foreach($recipients as $recipient)
        {
            $array_emails[$recipient->email1] = $recipient->getFullName();
        }

        //email settings
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com',465);
        $transport->setEncryption('ssl');
        $transport->setUsername('erp.olivia@gmail.com');
        $transport->setPassword('olivia_password!');
        $mailer = Swift_Mailer::newInstance($transport);

        //message settings
        $message = Swift_Message::newInstance();
        $message->setSubject('Offer');
        $message->setFrom(array('erp.olivia@gmail.com' => 'Ilux ERP System'));
        $message->setTo($array_emails);


        //attach files
        foreach($files as $file)
        {
            $message->attach(Swift_Attachment::fromPath('uploaded/product_files/'.$file->filename)->setFilename($file->label));
        }

        //set text
        $message->setBody(nl2br($text), 'text/html');

        //if sent
        if($mailer->send($message))
        {
            //TODO: inform user about success
            $this->redirect(Yii::app()->createUrl('/products/cards'));
        }
        //if not sent
        else
        {
            //TODO: inform user about failure
            $this->redirect(Yii::app()->createUrl('/product/cards'));
        }
    }

}