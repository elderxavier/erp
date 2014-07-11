<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ProductCardForm extends CFormModel
{
	public $code;
	public $name;
    public $category_id;

    public $current_card_id = null;


    //declare rules
	public function rules()
	{
		return array(
			// username and password are required
			array('code, name, category_id', 'required'),

			// password needs to be authenticated
			array('code', 'unique'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
    public function unique()
    {
        //if no errors (all fields not empty)
        if(!$this->hasErrors())
        {
            /* @var $card ProductCards */

            //try find product card by product-code
            $card = ProductCards::model()->findByAttributes(array('product_code' => $this->code));

            //if found
            if($card)
            {
                //if found card is not same as card that we need update (in that case product key can be the same)
                if(!($this->current_card_id != null && $this->current_card_id == $card->id))
                {
                    $this->addError('code','product code already used');
                }
            }
        }
    }
}
