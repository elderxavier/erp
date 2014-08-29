<?php

/**
 * This is the model class for table "operations_out_opt_items".
 *
 * The followings are the available columns in table 'operations_out_opt_items':
 * @property integer $id
 * @property integer $operation_id
 * @property integer $option_card_id
 * @property integer $qnt
 * @property integer $price
 * @property integer $discount_percent
 * @property integer $client_id
 * @property integer $date
 *
 * The followings are the available model relations:
 * @property OperationsOut $operation
 * @property OptionCards $optionCard
 */
class OperationsOutOptItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations_out_opt_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation_id, option_card_id, qnt, price, discount_percent, client_id, date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operation_id, option_card_id, qnt, price, discount_percent, client_id, date', 'safe', 'on'=>'search'),
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
			'operation' => array(self::BELONGS_TO, 'OperationsOut', 'operation_id'),
			'optionCard' => array(self::BELONGS_TO, 'OptionCards', 'option_card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'operation_id' => 'Operation',
			'option_card_id' => 'Option Card',
			'qnt' => 'Qnt',
			'price' => 'Price',
			'discount_percent' => 'Discount Percent',
			'client_id' => 'Client',
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
		$criteria->compare('operation_id',$this->operation_id);
		$criteria->compare('option_card_id',$this->option_card_id);
		$criteria->compare('qnt',$this->qnt);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount_percent',$this->discount_percent);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperationsOutOptItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
