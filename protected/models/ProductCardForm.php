<?php

/**
 * Class ProductCardForm
 */
class ProductCardForm extends CBaseForm
{
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
			array('code', 'unique', 'model_class' => 'ProductCards', 'current_id' => $this->current_card_id),
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
}
