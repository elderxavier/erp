<?php

/**
 * Class ProductCategoryForm
 */
class ProductCategoryForm extends CBaseForm
{
	public $name;
    public $remark;

    //declare rules
	public function rules()
	{
		return array(
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
