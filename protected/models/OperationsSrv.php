<?php

/**
 * This is the model class for table "operations_srv".
 *
 * The followings are the available columns in table 'operations_srv':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $service_id
 * @property integer $service_price
 * @property integer $ordered_date
 * @property integer $planned_date
 * @property integer $completed_date
 * @property integer $employee_user_id
 * @property integer $client_id
 *
 * The followings are the available model relations:
 * @property Users $employeeUser
 * @property InvoicesOut $invoice
 * @property ServiceCards $service
 */
class OperationsSrv extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations_srv';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_id, service_id, service_price, ordered_date, planned_date, completed_date, employee_user_id, client_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_id, service_id, service_price, ordered_date, planned_date, completed_date, employee_user_id, client_id', 'safe', 'on'=>'search'),
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
			'employeeUser' => array(self::BELONGS_TO, 'Users', 'employee_user_id'),
			'invoice' => array(self::BELONGS_TO, 'InvoicesOut', 'invoice_id'),
			'service' => array(self::BELONGS_TO, 'ServiceCards', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Invoice',
			'service_id' => 'Service',
			'service_price' => 'Service Price',
			'ordered_date' => 'Ordered Date',
			'planned_date' => 'Planned Date',
			'completed_date' => 'Completed Date',
			'employee_user_id' => 'Employee User',
			'client_id' => 'Client',
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
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('service_price',$this->service_price);
		$criteria->compare('ordered_date',$this->ordered_date);
		$criteria->compare('planned_date',$this->planned_date);
		$criteria->compare('completed_date',$this->completed_date);
		$criteria->compare('employee_user_id',$this->employee_user_id);
		$criteria->compare('client_id',$this->client_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperationsSrv the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
