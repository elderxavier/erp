<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    //authenticates user
    public function authenticate()
    {
        /* @var $user_record Users */

        //if have login and username
        if($this->username != null && $this->password != null)
        {
            //find user by login
            $user_record = Users::model()->with('userRights')->findByAttributes(array('username' => $this->username));
            //if user not found by login
            if($user_record===null)
                //error - user not found
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            //if user entered password and password from db not equal
            elseif($user_record->password !== md5($this->password))
                //error - invalid pass
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            //if no errors
            else
            {
                //set new user id (primary key from db)
                $this->_id=$user_record->id;

                //set all data from db to user-session/cookie
                $this->setState('id',$user_record->id);
                $this->setState('username',$user_record->username);
                $this->setState('email', $user_record->email);
                $this->setState('name',$user_record->name);
                $this->setState('surname', $user_record->surname);
                $this->setState('phone', $user_record->phone);
                $this->setState('address', $user_record->address);
                $this->setState('remark', $user_record->remark);
                $this->setState('role', $user_record->role);
                $this->setState('status',$user_record->status);
                $this->setState('avatar',$user_record->avatar);

                //get all rights
                $rights = array();

                /* @var $user_right UserRights */
                /* @var $right Rights */

                //if user has no root rights
                if($user_record -> role == 0)
                {
                    foreach($user_record->userRights as $user_right)
                    {
                        $right = Rights::model()->findByPk($user_right->rights_id);
                        $rights[$right->label] = 1;
                    }
                }
                //if user has root rights
                else
                {
                    //get all rights
                    $all_rights = Rights::model()->findAll();

                    //pass through array of rights
                    foreach($all_rights as $right)
                    {
                        //set right
                        $rights[$right->label] = 1;
                    }
                }


                $this->setState('rights',$rights);

                //no errors
                $this->errorCode=self::ERROR_NONE;
            }
        }
        //if nothing entered
        else
        {
            //error - unknown
            $this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        }
        //return error code
        return !$this->errorCode;
    }

    //returns id
    public function getId()
    {
        return $this->_id;
    }

}