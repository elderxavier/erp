<?php

/**
 * Class UserForm
 */
class UserForm extends CBaseForm
{
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
            //username and email must be unique
            array('username, email','unique','model_class' => 'Users', 'current_id' => $this->current_user_id),

            //safe attributes
            array('name, surname, phone, email, address, remark, role, position_id','safe'),

            //avatar-file validation
            array(
                'avatar',//field name
                'file', //file validation
                'types'=>'jpg, gif, png', //available file-types
                'allowEmpty' =>true, //can be empty
                'maxSize' => 1000000, //1 mb
                'wrongType' => $this->messages['file has wrong type'], //message for wrong-type error
                'tooLarge' => $this->messages['file is too large'], //message for 'too large' error
            ),
        );

        //if new user created
        if($this->current_user_id == null)
        {
            //password, username and email cannot be empty
            $rules[] = array('username, password, repeat_password, email', 'required','message'=> $this->messages['fill the field'].' "{attribute}"');

            //field 'repeat password' and 'password' must have same value
            $rules[] = array('repeat_password', 'equal', 'to' => 'password');
        }
        //if old user updating
        else
        {
            //required username and email, password can be empty
            $rules[] = array('username, email', 'required','message'=> $this->messages['fill the field'].' "{attribute}"');
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
}