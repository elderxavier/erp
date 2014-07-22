<?php

class ServiceForm extends CBaseForm
{
    public $label;
    public $remark;
    public $start_date;
    public $close_date;
    public $client_id;
    public $operation_id;
    public $problem_type_id;
    public $resolutions_arr;
    public $client_name;
    public $city_id;
    public $worker_id;

    public function rules()
    {
        return array(
            array('label, start_date, close_date, client_id, problem_type_id', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('label, remark, start_date, close_date, client_id, operation_id, problem_type_id', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'label' => $this->labels['label'],
            'remark' => $this->labels['description'],
            'start_date' => $this->labels['start date'],
            'close_date' => $this->labels['close date'],
            'client_id' => $this->labels['client'],
            'operation_id' => $this->labels['product info'],
            'problem_type_id' => $this->labels['problem type'],
            'city_id' => $this->labels['city'],
            'worker_id' => $this->labels['worker'],
        );
    }
}