<?php

class ActiveTasks extends Widget {

    public function run()
    {
        //get just related with current user services
        $count = ServiceProcesses::model()->countByAttributes(array('current_employee_id' => Yii::app()->user->id, 'read_by_employee' => 0));

        //render
        $this->render('active_tasks',array('count' => $count));
    }
}