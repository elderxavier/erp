<?php

/**
 * Class ProductCardForm
 */
class ProductCardForm extends CBaseForm
{
    //max validation file size
    public $max_validation_file_size = 1000000;

    //for array of files validation
    public $file_arr_params = array();

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

    /**
     * Validates every file in array
     * @param $form_name
     * @param $field_name
     * @return bool
     */
    public function validateArrayOfFiles($form_name,$field_name)
    {
        $arrTypesAvailable = array(
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp'
        );

        //get all arrays
        $names = $_FILES[$form_name]['name'][$field_name];
        $mime_types = $_FILES[$form_name]['type'][$field_name];
        $tmp_names = $_FILES[$form_name]['tmp_name'][$field_name];
        $file_errors = $_FILES[$form_name]['error'][$field_name];
        $file_size = $_FILES[$form_name]['size'][$field_name];

        //set to model-param-array
        foreach($file_size as $index => $size)
        {
            $this->file_arr_params[$index]['size'] = $size;
            $this->file_arr_params[$index]['error'] = $file_errors[$index];
            $this->file_arr_params[$index]['tmp_name'] = $tmp_names[$index];
            $this->file_arr_params[$index]['type'] = $mime_types[$index];
            $this->file_arr_params[$index]['name'] = $names[$index];

            //get extension
            $name_parts = explode(".",$names[$index]);
            $this->file_arr_params[$index]['extension'] = $ext = $name_parts[count($name_parts)-1];

            //random filename
            $this->file_arr_params[$index]['random_name'] = $this->generateRandomString().".".$ext;
        }

        //check every file for type
        foreach($this->file_arr_params as $index => $file_params)
        {
            //if type not found in array
            if(!in_array($file_params['type'],$arrTypesAvailable) && $file_params['size'] > 0)
            {
                //add error
                $this->addError($form_name.'['.$field_name.']'.'['.$index.']',$this->messages['wrong image type']);
            }

            //if size bigger than maximum validation size
            if($file_params['size'] > $this->max_validation_file_size)
            {
                //add error
                $this->addError($form_name.'['.$field_name.']'.'['.$index.']',$this->messages['image is too big']);
            }
        }

        //returns true if no errors
        return !$this->hasErrors();
    }

    /**
     * Generates random string
     * @param int $length
     * @param bool $uppercase
     * @return string
     */
    public function generateRandomString($length = 8, $uppercase = false)
    {
        //string of chars
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        //count of chars
        $numChars = strlen($chars);
        //empty string
        $string = '';
        //collect random chars from char-string
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        //returns string (can be in uppercase if uppercase set to true)
        return $uppercase ? strtoupper($string) : $string;
    }
}
