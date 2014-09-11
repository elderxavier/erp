<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $address
 * @property string $remark
 * @property string $additional_params
 * @property integer $role
 * @property integer $status
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 * @property string $avatar
 * @property integer $position_id
 * @property integer $city_id
 *
 * The followings are the available model relations:
 * @property ServiceProcesses[] $serviceProcesses
 * @property ServiceProcesses[] $serviceProcesses1
 * @property ServiceProcesses[] $serviceProcesses2
 * @property ServiceResolutions[] $serviceResolutions
 * @property StockMovementStages[] $stockMovementStages
 * @property UserRights[] $userRights
 * @property Positions $position
 * @property UserCities $city
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role, status, date_created, date_changed, user_modified_by, position_id, city_id', 'numerical', 'integerOnly'=>true),
			array('username, password, email, name, surname, phone, address, remark, additional_params, avatar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, name, surname, phone, address, remark, additional_params, role, status, date_created, date_changed, user_modified_by, avatar, position_id, city_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'serviceProcesses' => array(self::HAS_MANY, 'ServiceProcesses', 'user_modified_by'),
			'serviceProcesses1' => array(self::HAS_MANY, 'ServiceProcesses', 'current_employee_id'),
			'serviceProcesses2' => array(self::HAS_MANY, 'ServiceProcesses', 'user_created_by'),
			'serviceResolutions' => array(self::HAS_MANY, 'ServiceResolutions', 'by_employee_id'),
			'stockMovementStages' => array(self::HAS_MANY, 'StockMovementStages', 'user_operator_id'),
			'userRights' => array(self::HAS_MANY, 'UserRights', 'user_id'),
			'position' => array(self::BELONGS_TO, 'Positions', 'position_id'),
			'city' => array(self::BELONGS_TO, 'UserCities', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'name' => 'Name',
			'surname' => 'Surname',
			'phone' => 'Phone',
			'address' => 'Address',
			'remark' => 'Remark',
			'additional_params' => 'Additional Params',
			'role' => 'Role',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_changed' => 'Date Changed',
			'user_modified_by' => 'User Modified By',
			'avatar' => 'Avatar',
			'position_id' => 'Position',
			'city_id' => 'City',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('additional_params',$this->additional_params,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('user_modified_by',$this->user_modified_by);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Returns JSON encoded array found by name(surname too) users
     * @param string $name
     * @param bool $auto_complete
     * @return array|Users[]
     */
    public function getAllByNameSurname($name = '',$auto_complete = true)
    {
        /* @var $users self[] */

        $sql = "SELECT * FROM ".$this->tableName()."";
        $result = array();

        $name = trim($name);
        $names = explode(" ",$name,2);

        if(!empty($name))
        {
            if(count($names) > 1)
            {
                $sql = "SELECT * FROM ".$this->tableName()." WHERE name LIKE '%".$names[0]."%' AND surname LIKE '%".$names[1]."%'";
            }
            else
            {
                $sql = "SELECT * FROM ".$this->tableName()." WHERE name LIKE '%".$name."%' OR surname LIKE '%".$name."%'";
            }
        }

        $users = Users::model()->findAllBySql($sql);

        if($auto_complete)
        {
            foreach($users as $user)
            {
                $result[] = array('label' => $user->name.' '.$user->surname, 'id' => $user->id);
            }
        }
        else
        {
            $result = $users;
        }

        return $result;
    }
}
