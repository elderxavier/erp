<?php

/**
 * This is the model class for table "product_in_stock".
 *
 * The followings are the available columns in table 'product_in_stock':
 * @property integer $id
 * @property integer $stock_id
 * @property integer $product_card_id
 * @property integer $qnt
 * @property integer $date_changed
 * @property integer $date_created
 *
 * The followings are the available model relations:
 * @property ProductCards $productCard
 * @property Stocks $stock
 */
class ProductInStock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_in_stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stock_id, product_card_id, qnt, date_changed, date_created', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, stock_id, product_card_id, qnt, date_changed, date_created', 'safe', 'on'=>'search'),
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
			'productCard' => array(self::BELONGS_TO, 'ProductCards', 'product_card_id'),
			'stock' => array(self::BELONGS_TO, 'Stocks', 'stock_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stock_id' => 'Stock',
			'product_card_id' => 'Product Card',
			'qnt' => 'Qnt',
			'date_changed' => 'Date Changed',
			'date_created' => 'Date Created',
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
		$criteria->compare('stock_id',$this->stock_id);
		$criteria->compare('product_card_id',$this->product_card_id);
		$criteria->compare('qnt',$this->qnt);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('date_created',$this->date_created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductInStock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
