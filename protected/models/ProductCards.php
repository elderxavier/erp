<?php

/**
 * This is the model class for table "product_cards".
 *
 * The followings are the available columns in table 'product_cards':
 * @property integer $id
 * @property integer $category_id
 * @property string $product_name
 * @property string $product_code
 * @property string $description
 * @property integer $default_price
 * @property string $units
 * @property string $additional_params
 * @property integer $status
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 *
 * The followings are the available model relations:
 * @property OperationsIn[] $operationsIns
 * @property OperationsOut[] $operationsOuts
 * @property ProductCardCategories $category
 * @property ProductFiles[] $productFiles
 * @property ProductInStock[] $productInStocks
 */
class ProductCards extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_cards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, default_price, status, date_created, date_changed, user_modified_by', 'numerical', 'integerOnly'=>true),
			array('product_name, product_code, description, units, additional_params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, product_name, product_code, description, default_price, units, additional_params, status, date_created, date_changed, user_modified_by', 'safe', 'on'=>'search'),
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
			'operationsIns' => array(self::HAS_MANY, 'OperationsIn', 'product_card_id'),
			'operationsOuts' => array(self::HAS_MANY, 'OperationsOut', 'product_card_id'),
			'category' => array(self::BELONGS_TO, 'ProductCardCategories', 'category_id'),
			'productFiles' => array(self::HAS_MANY, 'ProductFiles', 'product_card_id'),
			'productInStocks' => array(self::HAS_MANY, 'ProductInStock', 'product_card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'product_name' => 'Product Name',
			'product_code' => 'Product Code',
			'description' => 'Description',
			'default_price' => 'Default Price',
			'units' => 'Units',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_code',$this->product_code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('default_price',$this->default_price);
		$criteria->compare('units',$this->units,true);
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
	 * @return ProductCards the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
