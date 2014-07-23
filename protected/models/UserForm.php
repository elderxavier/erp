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
            array('username, email','unique','model_class' => 'Users', 'current_id' => $this->current_user_id),
            array('name, surname, phone, email, address, remark, role, position_id','safe')
        );

        //if new user created
        if($this->current_user_id == null)
        {
            //password, username and email cannot be empty
            $rules[] = array('username, password, repeat_password, email', 'required','message'=> $this->messages['fill the field'].' "{attribute}"');
            $rules[] = array('repeat_password', 'equal', 'to' => 'password');
        }
        //if old user updating
        else
        {
            //password can be empty
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
}