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

    /**
     * Returns array of rules
     * @return array
     */
    public function rules()
    {
        return array(
            array('username, password, email, function', 'required','message'=> $this->messages['fill the field'].' "{attribute}"'),
        );
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
        );
    }
}