<?php

/**
 * This is the model class for table "operations_srv_items".
 *
 * The followings are the available columns in table 'operations_srv_items':
 * @property integer $id
 * @property integer $operaion_id
 * @property integer $service_process_id
 * @property integer $price
 * @property integer $under_warranty
 * @property integer $date
 *
 * The followings are the available model relations:
 * @property OperationsOut $operaion
 * @property ServiceProcesses $serviceProcess
 */
class OperationsSrvItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations_srv_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operaion_id, service_process_id, price, under_warranty, date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operaion_id, service_process_id, price, under_warranty, date', 'safe', 'on'=>'search'),
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
			'operaion' => array(self::BELONGS_TO, 'OperationsOut', 'operaion_id'),
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
			'operaion_id' => 'Operaion',
			'service_process_id' => 'Service Process',
			'price' => 'Price',
			'under_warranty' => 'Under Warranty',
			'date' => 'Date',
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
		$criteria->compare('operaion_id',$this->operaion_id);
		$criteria->compare('service_process_id',$this->service_process_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('under_warranty',$this->under_warranty);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperationsSrvItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
