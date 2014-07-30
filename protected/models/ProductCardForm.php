<?php

/**
 * Class ProductCardForm
 */
class ProductCardForm extends CBaseForm
{
    public $files;

    public $product_code;
	public $product_name;
    public $category_id;
    public $description;
    public $units;

    public $current_card_id = null;

    /**
     * Declares rules
     * @return array
     */
    public function rules()
	{
		return array(
			// username and password are required
			array('product_code, product_name, category_id', 'required', 'message'=> $this->messages['fill the field'].' "{attribute}"'),

			// password needs to be authenticated
			array('product_code', 'unique', 'model_class' => 'ProductCards', 'current_id' => $this->current_card_id),

            // rules for file validation
            array('files', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' =>true, 'maxSize' => 1000000, 'maxFiles' => 5),
		);
	}

    /**
     * Sets labels for attributes
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'product_code' => $this->labels['product code'],
            'product_name' => $this->labels['product name'],
            'category_id' => $this->labels['category'],
            'description' => $this->labels['description'],
            'dimension_units' => $this->labels['dimension units'],
            'units' => $this->labels['units'],
            'liters' => $this->labels['liters'],
            'kg' => $this->labels['kg'],
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
