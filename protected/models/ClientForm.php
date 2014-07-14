<?php

/**
 * Class ClientForm
 */
class ClientForm extends CBaseForm
{
    public $name;
    public $company_name;
    public $surname;
    public $personal_code;
    public $company_code;
    public $vat_code;
    public $phone_1;
    public $phone_2;
    public $email_1;
    public $email_2;
    public $remark;
    public $remark_for_service;

    public $company;
    public $current_client_id = null;


    /**
     * Declares rules for fields
     * @return array
     */
    public function rules()
	{
        //main rules
        $rules = array(
            array('vat_code, phone_1, email_1', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
        );

        //for company
        if($this->company)
        {
            $rules[]=array('company_name, company_code', 'required', 'message' => $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('company_code', 'unique_cc');
        }
        //for single person
        else
        {
            $rules[]=array('personal_code, name, surname','required', 'message'=> $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('personal_code', 'unique_pc');
        }

        return $rules;
	}

    /**
     * Labels for fields
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'name' => $this->labels['name'],
            'company_name' => $this->labels['company name'],
            'surname' => $this->labels['surname'],
            'personal_code' => $this->labels['personal code'],
            'company_code' => $this->labels['company code'],
            'vat_code' => $this->labels['vat code'],
            'phone_1' => $this->labels['phone 1'],
            'phone_2' => $this->labels['phone 2'],
            'email_1' => $this->labels['email 1'],
            'email_2' => $this->labels['email 2'],
            'remark' => $this->labels['remark'],
            'remark_for_service' => $this->labels['remark for service'],
        );
    }

    /**
     * this function checks some field in some table for uniqueness
     * @param $MODEL_NAME string name of model
     * @param $param_name string name of unique parameter
     * @param $param_value string value for check
     * @param $cur_id int id of current object if update
     * @return bool error or not
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
     * validator to check company code uniqueness
     */
    public function unique_cc()
    {
        if($this->base_unique_err('Clients','company_code',$this->company_code,$this->current_client_id))
        {
            $this->addError('company_code',$this->messages['company code already used']);
        }
    }

    /**
     * validator to check personal code uniqueness
     */
    public function unique_pc()
    {
        if($this->base_unique_err('Clients','personal_code',$this->personal_code,$this->current_client_id))
        {
            $this->addError('personal_code',$this->messages['personal code already used']);
        }
    }
}
