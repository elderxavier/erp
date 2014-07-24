<?php

/**
 * Class CBaseForm
 */
class CBaseForm extends CFormModel
{
    //declare labels and messages array
    protected $labels = array();
    protected $messages = array();

    //max validation file size
    public $max_validation_file_size = 1000000;

    //for single file validation
    public $file_params = array();

    //for array of files validation
    public $file_arr_params = array();


    public function __construct($scenario='')
    {
        $this->labels = Labels::model()->getLabels();
        $this->messages = FormMessages::model()->getLabels();

        parent::__construct($scenario);
    }

    /**
     * Checks some field in some table for uniqueness
     * @param $MODEL_NAME string name of model related with table in db
     * @param $param_name string name of unique parameter
     * @param $param_value string value for check
     * @param $cur_id int id of current object (need set it when update)
     * @return bool error
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
     * Checks for uniqueness and adds error if field not unique
     * @param $attribute
     * @param $param
     */
    public function unique($attribute,$param)
    {
        if($this->base_unique_err($param['model_class'],$attribute,$this->$attribute,$param['current_id']))
        {
            $this->addError($attribute,$this->labels[$attribute].' '.$this->messages['already used']);
        }
    }

    /**
     * Compares attribute with another value and adds error if the not equal
     * @param $attribute
     * @param $param
     */
    public function equal($attribute,$param)
    {
        $value_to_equal = $param['to'];
        if($this->$attribute != $this->$value_to_equal)
        {
            $this->addError($attribute, $this->messages['fields'].' "'.$this->labels[$attribute].'" and "'.$this->labels[$value_to_equal].'" '.$this->messages['must be equal']);
        }
    }


    /**
     * Validates file and stores parameters of file in model
     * @param $form_name
     * @param $field_name
     * @return bool
     */
    public function validateFile($form_name,$field_name)
    {
        //available types for images
        $arrTypesImages = array
        (
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp'
        );

        //get main parameters and set them to model
        $this->file_params['name'] = $name = $_FILES[$form_name]['name'][$field_name];
        $this->file_params['type'] = $type = $_FILES[$form_name]['type'][$field_name];
        $this->file_params['tmp_name'] = $tmp_name = $_FILES[$form_name]['tmp_name'][$field_name];
        $this->file_params['error'] = $error = $_FILES[$form_name]['error'][$field_name];
        $this->file_params['size'] = $size = $_FILES[$form_name]['size'][$field_name];
        //get extension
        $name_parts = explode(".",$name);
        $this->file_params['extension'] = $ext = $name_parts[count($name_parts)-1];
        //random filename
        $this->file_params['random_name'] = $this->generateRandomString().".".$ext;

        //if type not found in array
        if(!in_array($type,$arrTypesImages) && $this->file_size > 0)
        {
            //add error
            $this->addError($field_name,$this->messages['wrong image type']);
        }

        //if size bigger than maximum validation size
        if($size > $this->max_validation_file_size)
        {
            //add error
            $this->addError($field_name,$this->messages['image is too big']);
        }

        //returns true if no errors
        return !$this->hasErrors();
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