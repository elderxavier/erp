<?php

/**
 * This is the model class for table "service_resolutions".
 *
 * The followings are the available columns in table 'service_resolutions':
 * @property integer $id
 * @property integer $service_process_id
 * @property integer $by_employee_id
 * @property string $remark_for_employee
 * @property string $remark_by_employee
 * @property integer $process_current_status
 * @property integer $status
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 *
 * The followings are the available model relations:
 * @property Users $byEmployee
 * @property ServiceProcesses $serviceProcess
 */
class ServiceResolutions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_resolutions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_process_id, by_employee_id, process_current_status, status, date_created, date_changed, user_modified_by', 'numerical', 'integerOnly'=>true),
			array('remark_for_employee, remark_by_employee', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service_process_id, by_employee_id, remark_for_employee, remark_by_employee, process_current_status, status, date_created, date_changed, user_modified_by', 'safe', 'on'=>'search'),
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
			'byEmployee' => array(self::BELONGS_TO, 'Users', 'by_employee_id'),
			'serviceProcess' => array(self::BELONGS_TO, 'ServiceProcesses', 'service_process_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_process_id' => 'Service Process',
			'by_employee_id' => 'By Employee',
			'remark_for_employee' => 'Remark For Employee',
			'remark_by_employee' => 'Remark By Employee',
			'process_current_status' => 'Process Current Status',
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
		$criteria->compare('service_process_id',$this->service_process_id);
		$criteria->compare('by_employee_id',$this->by_employee_id);
		$criteria->compare('remark_for_employee',$this->remark_for_employee,true);
		$criteria->compare('remark_by_employee',$this->remark_by_employee,true);
		$criteria->compare('process_current_status',$this->process_current_status);
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
	 * @return ServiceResolutions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
