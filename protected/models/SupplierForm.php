<?php

/**
 * Class ClientForm
 */
class SupplierForm extends CBaseForm
{
    public $name;
    public $company_name;
    public $surname;
    public $personal_code;
    public $company_code;
    public $vat_code;
    public $phone1;
    public $phone2;
    public $email1;
    public $email2;
    public $remark;

    public $company;
    public $current_supplier_id = null;


    /**
     * Declares rules for fields
     * @return array
     */
    public function rules()
    {
        //main rules
        $rules = array(
            array('vat_code, phone1, email1', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('name, company_name, surname, personal_code, company_code, vat_code, phone1, phone2, email1, email2, remark', 'safe')
        );

        //for company
        if($this->company)
        {
            $rules[]=array('company_name, company_code', 'required', 'message' => $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('company_code', 'unique', 'model_class' => 'Suppliers', 'current_id' => $this->current_supplier_id);
        }
        //for single person
        else
        {
            $rules[]=array('personal_code, name, surname','required', 'message'=> $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('personal_code', 'unique', 'model_class' => 'Suppliers', 'current_id' => $this->current_supplier_id);
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
            'phone1' => $this->labels['phone 1'],
            'phone2' => $this->labels['phone 2'],
            'email1' => $this->labels['email 1'],
            'email2' => $this->labels['email 2'],
            'remark' => $this->labels['remark'],
            'company' => $this->labels['company'],
        );
    }

    /**
     * Checks some field for unique in table
     * @param $attribute
     * @param $param
     * @return bool
     */
    public function unique($attribute,$param)
    {
        /* @var $MODEL_NAME CActiveRecord */
        /* @var $obj CActiveRecord */

        $MODEL_NAME = $param['model_class'];
        $param_name = $attribute;
        $param_value = $this->$attribute;
        $cur_id = $param['current_id'];


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
                    $this->addError($attribute,$this->labels[$attribute].' '.$this->messages['already used']);
                }
            }
        }

        //no errors
        return false;
    }
}
