<?php

/**
 * This is the model class for table "operations_out_items".
 *
 * The followings are the available columns in table 'operations_out_items':
 * @property integer $id
 * @property integer $product_card_id
 * @property integer $invoice_id
 * @property integer $qnt
 * @property integer $date
 * @property integer $price
 * @property integer $stock_id
 * @property integer $stock_qnt_after_op
 * @property integer $client_id
 * @property integer $discount_percent
 *
 * The followings are the available model relations:
 * @property OperationsOut $invoice
 * @property ProductCards $productCard
 * @property Stocks $stock
 * @property ServiceProcesses[] $serviceProcesses
 */
class OperationsOutItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations_out_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_card_id, invoice_id, qnt, date, price, stock_id, stock_qnt_after_op, client_id, discount_percent', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_card_id, invoice_id, qnt, date, price, stock_id, stock_qnt_after_op, client_id, discount_percent', 'safe', 'on'=>'search'),
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
			'productCard' => array(self::BELONGS_TO, 'ProductCards', 'product_card_id'),
			'stock' => array(self::BELONGS_TO, 'Stocks', 'stock_id'),
			'serviceProcesses' => array(self::HAS_MANY, 'ServiceProcesses', 'operation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_card_id' => 'Product Card',
			'invoice_id' => 'Invoice',
			'qnt' => 'Qnt',
			'date' => 'Date',
			'price' => 'Price',
			'stock_id' => 'Stock',
			'stock_qnt_after_op' => 'Stock Qnt After Op',
			'client_id' => 'Client',
			'discount_percent' => 'Discount Percent',
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
		$criteria->compare('product_card_id',$this->product_card_id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('qnt',$this->qnt);
		$criteria->compare('date',$this->date);
		$criteria->compare('price',$this->price);
		$criteria->compare('stock_id',$this->stock_id);
		$criteria->compare('stock_qnt_after_op',$this->stock_qnt_after_op);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('discount_percent',$this->discount_percent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperationsOutItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
