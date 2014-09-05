<?php

/**
 * This is the model class for table "stock_movement_stages".
 *
 * The followings are the available columns in table 'stock_movement_stages':
 * @property integer $id
 * @property integer $movement_id
 * @property integer $movement_status_id
 * @property integer $user_operator_id
 * @property string $operator_name
 * @property integer $time
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property Users $userOperator
 * @property StockMovements $movement
 * @property StockMovementStatuses $movementStatus
 */
class StockMovementStages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_movement_stages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movement_id, movement_status_id, user_operator_id, time', 'numerical', 'integerOnly'=>true),
			array('operator_name, remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movement_id, movement_status_id, user_operator_id, operator_name, time, remark', 'safe', 'on'=>'search'),
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
			'userOperator' => array(self::BELONGS_TO, 'Users', 'user_operator_id'),
			'movement' => array(self::BELONGS_TO, 'StockMovements', 'movement_id'),
			'movementStatus' => array(self::BELONGS_TO, 'StockMovementStatuses', 'movement_status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'movement_id' => 'Movement',
			'movement_status_id' => 'Movement Status',
			'user_operator_id' => 'User Operator',
			'operator_name' => 'Operator Name',
			'time' => 'Time',
			'remark' => 'Remark',
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
		$criteria->compare('movement_id',$this->movement_id);
		$criteria->compare('movement_status_id',$this->movement_status_id);
		$criteria->compare('user_operator_id',$this->user_operator_id);
		$criteria->compare('operator_name',$this->operator_name,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockMovementStages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
