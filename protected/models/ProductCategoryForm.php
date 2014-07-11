<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ProductCategoryForm extends CFormModel
{
	public $category_name;

    //declare rules
	public function rules()
	{
		return array(
			// username and password are required
			array('category_name', 'required'),
		);
	}
}
