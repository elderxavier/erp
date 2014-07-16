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
    public $phone1;
    public $phone2;
    public $email1;
    public $email2;
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
            array('vat_code, phone1, email1', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),
            array('name, company_name, surname, personal_code, company_code, vat_code, phone1, phone2, email1, email2, remark, remark_for_service', 'safe')
        );

        //for company
        if($this->company)
        {
            $rules[]=array('company_name, company_code', 'required', 'message' => $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('company_code', 'unique', 'model_class' => 'Clients', 'current_id' => $this->current_client_id);
        }
        //for single person
        else
        {
            $rules[]=array('personal_code, name, surname','required', 'message'=> $this->messages['fill the field'].' "{attribute}"');
            $rules[]=array('personal_code', 'unique', 'model_class' => 'Clients', 'current_id' => $this->current_client_id);
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
            'remark_for_service' => $this->labels['remark for service'],
            'company' => $this->labels['company'],
        );
    }

}
