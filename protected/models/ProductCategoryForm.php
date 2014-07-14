<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ProductCategoryForm extends CBaseForm
{
	public $name;
    public $remark;

    //declare rules
	public function rules()
	{
		return array(
			// username and password are required
			array('name', 'required','message'=> $this->messages['fill the field'].' "{attribute}"'),
		);
	}

    public function attributeLabels()
    {
        return array(
            'name' => $this->labels['category name'],
            'remark' => $this->labels['remark'],
        );
    }
}
