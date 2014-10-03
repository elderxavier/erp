<?php

class AjaxController extends Controller
{
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

    public function actionAjaxTaskChecker()
    {
        //get just related with current user services
        $count = ServiceProcesses::model()->countByAttributes(array('current_employee_id' => Yii::app()->user->id, 'read_by_employee' => 0));

        //render active tasks
        $this->renderPartial('_active_tasks_ajax',array('count' => $count));
    }
}