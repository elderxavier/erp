<?php

class SrvEditForm extends CBaseForm
{
    public $problem_type_id;
    public $remark;
    public $city_id;
    public $worker_id;
    public $message_to_worker;

    public function rules()
    {
        return array(
            array('city_id, worker_id, remark, problem_type_id, message_to_worker', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('city_id, worker_id, remark, message_to_worker', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'remark' => $this->labels['description'],
            'problem_type_id' => $this->labels['problem type'],
            'city_id' => $this->labels['city'],
            'worker_id' => $this->labels['worker'],
            'message_to_worker' => $this->labels['message to worker'],
        );
    }
}