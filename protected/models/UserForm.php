<?php

/**
 * Class UserForm
 */
class UserForm extends CBaseForm
{

    //max validation file size
    public $max_validation_file_size = 1000000;

    //for single file validation
    public $file_params = array();


    public $username;
    public $password;
    public $repeat_password;
    public $email;
    public $name;
    public $surname;
    public $function;
    public $phone;
    public $address;
    public $remark;
    public $role;
    public $avatar;
    public $position_id;
    public $city_id;

    public $current_user_id = null;

    /**
     * Returns array of rules
     * @return array
     */
    public function rules()
    {
        //main rules
        $rules = array(
            array('username, email','unique','model_class' => 'Users', 'current_id' => $this->current_user_id),
            array('name, surname, phone, email, address, remark, role, position_id','safe')
        );

        //if new user created
        if($this->current_user_id == null)
        {
            //password, username and email cannot be empty
            $rules[] = array('username, password, repeat_password, email', 'required','message'=> $this->messages['fill the field'].' "{attribute}"');
            $rules[] = array('repeat_password', 'equal', 'to' => 'password');
//            $rules[] = array('avatar', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' =>true, 'maxSize' => 1024);
        }
        //if old user updating
        else
        {
            //password can be empty
            $rules[] = array('username, email', 'required','message'=> $this->messages['fill the field'].' "{attribute}"');
//            $rules[] = array('avatar', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' =>true, 'maxSize' => 1024);
        }

        return $rules;
    }

    /**
     * Labels for attributes
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username' => $this->labels['username'],
            'password' => $this->labels['password'],
            'email' => $this->labels['email'],
            'name' => $this->labels['name'],
            'surname' => $this->labels['surname'],
            'function' => $this->labels['function'],
            'phone' => $this->labels['phone'],
            'address' => $this->labels['address'],
            'remark' => $this->labels['remarks'],
            'role' => $this->labels['role'],
            'avatar' => $this->labels['avatar'],
            'repeat_password' => $this->labels['repeat password'],
            'rights' => $this->labels['rights'],
            'position' => $this->labels['position'],
            'city_id' => $this->labels['city'],
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
        if(!in_array($type,$arrTypesImages) && $this->file_params['error'] == 0)
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