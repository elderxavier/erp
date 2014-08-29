<?php

/**
 * This is the model class for table "operations_out_opt_items".
 *
 * The followings are the available columns in table 'operations_out_opt_items':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $card_id
 * @property integer $qnt
 * @property integer $price
 * @property integer $discount_percent
 * @property integer $client_id
 * @property integer $date
 *
 * The followings are the available model relations:
 * @property OperationsOut $invoice
 * @property ProductCards $card
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
			array('invoice_id, card_id, qnt, price, discount_percent, client_id, date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_id, card_id, qnt, price, discount_percent, client_id, date', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'OperationsOut', 'invoice_id'),
			'card' => array(self::BELONGS_TO, 'ProductCards', 'card_id'),
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
			'card_id' => 'Card',
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
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('card_id',$this->card_id);
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
