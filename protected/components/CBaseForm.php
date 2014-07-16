<?php

/**
 * Class CBaseForm
 */
class CBaseForm extends CFormModel
{
    protected $labels = array();
    protected $messages = array();


    public function __construct($scenario='')
    {
        $this->labels = Labels::model()->getLabels();
        $this->messages = FormMessages::model()->getLabels();

        parent::__construct($scenario);
    }

    /**
     * Checks some field in some table for uniqueness
     * @param $MODEL_NAME string name of model related with table in db
     * @param $param_name string name of unique parameter
     * @param $param_value string value for check
     * @param $cur_id int id of current object (need set it when update)
     * @return bool error
     */
    public function base_unique_err($MODEL_NAME,$param_name,$param_value,$cur_id)
    {
        /* @var $MODEL_NAME CActiveRecord */
        /* @var $obj CActiveRecord */

        //if no errors (all required fields not empty)
        if(!$this->hasErrors())
        {
            //try find object by search value
            $obj = $MODEL_NAME::model()->findByAttributes(array($param_name => $param_value));

            //if found
            if($obj)
            {
                //if found object is not same as object that we need update (in that case unique fields can be the same)
                if(!($cur_id != null && $cur_id == $obj->getAttribute('id')))
                {
                    //error
                    return true;
                }
            }
        }

        //no errors
        return false;
    }

    /**
     * Checks for uniqueness and adds error if field not unique
     * @param $attribute
     * @param $param
     */
    public function unique($attribute,$param)
    {
        if($this->base_unique_err($param['model_class'],$attribute,$this->$attribute,$param['current_id']))
        {
            $this->addError($attribute,$this->labels[$attribute].' '.$this->messages['already used']);
        }
    }
}