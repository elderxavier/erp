<?php

class ServiceForm extends CBaseForm
{
    public $client_name;
    public $city_id;
    public $worker_id;
    public $problem_type_id;
    public $remark;
    public $client_type;
    public $start_date;
    public $close_date;

    public function rules()
    {
        return array(
            array('start_date, close_date, worker_id, problem_type_id, remark', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('start_date, close_date, city_id, worker_id, problem_type_id, remark', 'safe'),
//            array('start_date, close_date', 'date', 'format' => 'MM/dd/YYYY'),
            array('start_date', 'dateSmaller', 'than' => 'close_date', 'format' => 'n/d/Y'),
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
            'client_type' => $this->labels['client type'],
        );
    }

    /**
     * Checks if attribute smaller than parameter
     * @param string $attribute
     * @param array $param
     */
    public function dateSmaller($attribute,$param)
    {
        if(!$this->hasErrors())
        {
            $check = $param['than'];
            $format = $param['format'];

            $check_time = DateTime::createFromFormat($format,$this->$check);
            $current_time = DateTime::createFromFormat($format,$this->$attribute);

            if($current_time->getTimestamp() > $check_time->getTimestamp())
            {
                $this->addError($attribute, $this->messages['value of field'].' "'.$this->labels[$attribute].'" '.$this->messages['must be smaller than value of'].' "'.$this->labels[$check].'"');
            }
        }
    }
}