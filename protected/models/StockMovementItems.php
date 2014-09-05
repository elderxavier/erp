<?php

/**
 * This is the model class for table "stock_movement_items".
 *
 * The followings are the available columns in table 'stock_movement_items':
 * @property integer $id
 * @property integer $movement_id
 * @property integer $product_card_id
 * @property integer $qnt
 * @property integer $item_weight
 * @property integer $src_stock_id
 * @property integer $trg_stock_id
 * @property integer $in_src_stock_after_movement
 * @property integer $in_trg_stock_after_movement
 * @property integer $date
 *
 * The followings are the available model relations:
 * @property StockMovements $movement
 * @property ProductCards $productCard
 * @property Stocks $srcStock
 * @property Stocks $trgStock
 */
class StockMovementItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_movement_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movement_id, product_card_id, qnt, item_weight, src_stock_id, trg_stock_id, in_src_stock_after_movement, in_trg_stock_after_movement, date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movement_id, product_card_id, qnt, item_weight, src_stock_id, trg_stock_id, in_src_stock_after_movement, in_trg_stock_after_movement, date', 'safe', 'on'=>'search'),
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
			'movement' => array(self::BELONGS_TO, 'StockMovements', 'movement_id'),
			'productCard' => array(self::BELONGS_TO, 'ProductCards', 'product_card_id'),
			'srcStock' => array(self::BELONGS_TO, 'Stocks', 'src_stock_id'),
			'trgStock' => array(self::BELONGS_TO, 'Stocks', 'trg_stock_id'),
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
			'product_card_id' => 'Product Card',
			'qnt' => 'Qnt',
			'item_weight' => 'Item Weight',
			'src_stock_id' => 'Src Stock',
			'trg_stock_id' => 'Trg Stock',
			'in_src_stock_after_movement' => 'In Src Stock After Movement',
			'in_trg_stock_after_movement' => 'In Trg Stock After Movement',
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
		$criteria->compare('movement_id',$this->movement_id);
		$criteria->compare('product_card_id',$this->product_card_id);
		$criteria->compare('qnt',$this->qnt);
		$criteria->compare('item_weight',$this->item_weight);
		$criteria->compare('src_stock_id',$this->src_stock_id);
		$criteria->compare('trg_stock_id',$this->trg_stock_id);
		$criteria->compare('in_src_stock_after_movement',$this->in_src_stock_after_movement);
		$criteria->compare('in_trg_stock_after_movement',$this->in_trg_stock_after_movement);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockMovementItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
