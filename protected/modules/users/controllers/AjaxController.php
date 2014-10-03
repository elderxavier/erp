<?php

class AjaxController extends Controller
{
    public function actionResetPassword($id = 0)
    {
        //if ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            //including swift mailer
            spl_autoload_unregister(array('YiiBase','autoload'));
            Yii::import('application.extensions.swift.swift_required', true);
            spl_autoload_register(array('YiiBase','autoload'));

            /* @var $user Users */
            $user = Users::model()->findByPk($id);

            //if found user
            if(!empty($user))
            {
                //try create new password
                try
                {
                    //create new random password
                    $new_password = uniqid();
                    $user->password = md5($new_password);
                    $user->update();
                }
                    //if failed
                catch(CDbException $e)
                {
                    $response = array();
                    $response['code'] = 'CREATE_ERROR';
                    exit (json_encode($response));
                }


                //send it to email
                $recipients = array($user->email => $user->username.' '.$user->surname);

                //email settings
                $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com',465);
                $transport->setEncryption('ssl');
                $transport->setUsername('erp.olivia@gmail.com');
                $transport->setPassword('olivia_password!');
                $mailer = Swift_Mailer::newInstance($transport);


                //message settings
                $message = Swift_Message::newInstance();
                $message->setSubject('Password reset');
                $message->setFrom(array('erp.olivia@gmail.com' => 'Ilux ERP System'));


                try
                {
                    $message->setTo($recipients);
                }
                catch(Swift_RfcComplianceException $e)
                {
                    $response = array();
                    $response['code'] = 'SEND_ERROR';
                    $response['password'] = $new_password;
                    exit (json_encode($response));
                }


                //set text
                $message->setBody($this->labels['your new password'].' - '.$new_password.'. '.$this->labels['you can change it in settings'], 'text/html');

                //try send to user
                try
                {
                    $mailer->send($message);
                    $response = array();
                    $response['code'] = 'OK';
                    exit (json_encode($response));
                }
                    //if failed
                catch(Exception $e)
                {
                    $response = array();
                    $response['code'] = 'SEND_ERROR';
                    $response['password'] = $new_password;
                    exit (json_encode($response));
                }

            }
            //if user not found
            else
            {
                throw new CHttpException(404);
            }
        }
        //if not ajax
        else
        {
            throw new CHttpException(404);
        }
    }

    /**
     * Auto-complete handler for name-surname in filtration template (usages : user_list.js, user_list.php)
     * @param $term
     * @param int $lim
     */
    public function actionAutoComplete($term,$lim = 5)
    {
        $arr = Users::model()->getAllByNameSurname($term);
        $arr = array_slice($arr,0,$lim);
        echo json_encode($arr);
    }//actionAutoComplete


    /**
     * Ajax filtration (usages : user_list.js, user_list.php)
     * @throws CHttpException
     */
    public function actionFilter()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $name_surname = Yii::app()->request->getParam('name_surname','');
            $position_id = Yii::app()->request->getParam('position_id', '');
            $city_id = Yii::app()->request->getParam('city_id','');

            $page = Yii::app()->request->getParam('page',1);
            $on_page = Yii::app()->request->getParam('on_page',3);

            $c = new CDbCriteria();
            if(!empty($name_surname))
            {
                $words = explode(' ',$name_surname,2);

                if(count($words) > 1)
                {
                    $c -> addCondition("name LIKE '%".$words[0]."%' AND surname LIKE '%".$words[1]."%'");
                }
                else
                {
                    $c -> addCondition("name LIKE '%".$name_surname."%' OR surname LIKE '%".$name_surname."%'");
                }
            }
            if(!empty($position_id))
            {
                $c -> addInCondition('position_id',array($position_id));
            }
            if(!empty($city_id))
            {
                $c -> addInCondition('city_id',array($city_id));
            }

            //get all filtered items
            $items = Users::model()->findAll($c);

            //pagination, get all items for page
            $pager = new CPagerComponent($items,$on_page,$page);
            $this->renderPartial('_filtered_table',array('pager' => $pager));
        }
        else
        {
            throw new CHttpException(404);
        }
    }//actionFilter
}