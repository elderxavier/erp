<?php

class ServiceForm extends CBaseForm
{
    public $client_name;
    public $city_id;
    public $worker_id;
    public $problem_type_id;
    public $remark;

    public function rules()
    {
        return array(
            array('client_name, worker_id, problem_type_id, remark', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('client_name, city_id, worker_id, problem_type_id, remark', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'client_name' => $this->labels['client'],
            'client_id' => $this->labels['client'],
            'remark' => $this->labels['description'],
            'start_date' => $this->labels['start date'],
            'close_date' => $this->labels['close date'],
            'problem_type_id' => $this->labels['problem type'],
            'city_id' => $this->labels['city'],
            'worker_id' => $this->labels['worker'],
            'select_priority' => $this->labels['select priority'],
        );
    }
}