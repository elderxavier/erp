<?php

/**
 * This is the model class for table "service_cards".
 *
 * The followings are the available columns in table 'service_cards':
 * @property integer $id
 * @property string $service_name
 * @property string $service_description
 * @property integer $default_price
 * @property string $additional_params
 * @property integer $status
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 *
 * The followings are the available model relations:
 * @property Clients[] $clients
 * @property Clients[] $clients1
 * @property OperationsSrv[] $operationsSrvs
 */
class ServiceCards extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_cards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('default_price, status, date_created, date_changed, user_modified_by', 'numerical', 'integerOnly'=>true),
			array('service_name, service_description, additional_params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service_name, service_description, default_price, additional_params, status, date_created, date_changed, user_modified_by', 'safe', 'on'=>'search'),
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
			'clients' => array(self::HAS_MANY, 'Clients', 'last_service_id'),
			'clients1' => array(self::HAS_MANY, 'Clients', 'next_service_id'),
			'operationsSrvs' => array(self::HAS_MANY, 'OperationsSrv', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_name' => 'Service Name',
			'service_description' => 'Service Description',
			'default_price' => 'Default Price',
			'additional_params' => 'Additional Params',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_changed' => 'Date Changed',
			'user_modified_by' => 'User Modified By',
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
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('service_description',$this->service_description,true);
		$criteria->compare('default_price',$this->default_price);
		$criteria->compare('additional_params',$this->additional_params,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('user_modified_by',$this->user_modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceCards the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
