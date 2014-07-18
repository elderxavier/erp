<?php

/**
 * This is the model class for table "stocks".
 *
 * The followings are the available columns in table 'stocks':
 * @property integer $id
 * @property string $name
 * @property string $location
 * @property string $description
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 *
 * The followings are the available model relations:
 * @property OperationsIn[] $operationsIns
 * @property OperationsOut[] $operationsOuts
 * @property ProductInStock[] $productInStocks
 */
class Stocks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stocks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_created, date_changed, user_modified_by', 'numerical', 'integerOnly'=>true),
			array('name, location, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, location, description, date_created, date_changed, user_modified_by', 'safe', 'on'=>'search'),
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
			'operationsIns' => array(self::HAS_MANY, 'OperationsIn', 'stock_id'),
			'operationsOuts' => array(self::HAS_MANY, 'OperationsOut', 'stock_id'),
			'productInStocks' => array(self::HAS_MANY, 'ProductInStock', 'stock_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'location' => 'Location',
			'description' => 'Description',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
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
	 * @return Stocks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Adds 'product_is_stock' record to table, or just increases quantity if product already in stock
     * @param int $card_id
     * @param int $qnt
     * @param int $stock_id
     * @return int
     */
    public function addToStockAndGetCount($card_id,$qnt,$stock_id)
    {
        /* @var $product_in_stock ProductInStock */

        //if stock found
        if(Stocks::model()->findByPk($stock_id))
        {
            //try find product in stock by card_id and stock_id
            $product_in_stock = ProductInStock::model()->findByAttributes(array('stock_id' => $stock_id, 'product_card_id' => $card_id));

            //if found
            if($product_in_stock)
            {
                $product_in_stock->qnt += $qnt;
                $product_in_stock->date_changed = time();
                $product_in_stock->update();
            }
            else
            {
                $product_in_stock = new ProductInStock();
                $product_in_stock -> product_card_id = $card_id;
                $product_in_stock -> qnt = $qnt;
                $product_in_stock -> stock_id = $stock_id;
                $product_in_stock -> date_changed = time();
                $product_in_stock -> date_created = time();
                $product_in_stock -> save();
            }

            return $product_in_stock->qnt;
        }
        else
        {
            return 0;
        }
    }
}
