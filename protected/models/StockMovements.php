<?php

/**
 * This is the model class for table "stock_movements".
 *
 * The followings are the available columns in table 'stock_movements':
 * @property integer $id
 * @property integer $src_stock_id
 * @property integer $trg_stock_id
 * @property integer $date
 * @property integer $status_id
 * @property string $car_number
 * @property string $car_brand
 *
 * The followings are the available model relations:
 * @property StockMovementItems[] $stockMovementItems
 * @property StockMovementStages[] $stockMovementStages
 * @property StockMovementStatuses $status
 * @property Stocks $srcStock
 * @property Stocks $trgStock
 */
class StockMovements extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_movements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('src_stock_id, trg_stock_id, date, status_id', 'numerical', 'integerOnly'=>true),
			array('car_number, car_brand', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, src_stock_id, trg_stock_id, date, status_id, car_number, car_brand', 'safe', 'on'=>'search'),
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
			'stockMovementItems' => array(self::HAS_MANY, 'StockMovementItems', 'movement_id'),
			'stockMovementStages' => array(self::HAS_MANY, 'StockMovementStages', 'movement_id'),
			'status' => array(self::BELONGS_TO, 'StockMovementStatuses', 'status_id'),
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
			'src_stock_id' => 'Src Stock',
			'trg_stock_id' => 'Trg Stock',
			'date' => 'Date',
			'status_id' => 'Status',
			'car_number' => 'Car Number',
			'car_brand' => 'Car Brand',
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
		$criteria->compare('src_stock_id',$this->src_stock_id);
		$criteria->compare('trg_stock_id',$this->trg_stock_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('car_number',$this->car_number,true);
		$criteria->compare('car_brand',$this->car_brand,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockMovements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Calculates total weight
     * @param bool $net
     * @param bool $kg
     * @return float|int
     */
    public function calculateTotalWeight($net = true, $kg = false)
    {
        $items = $this->stockMovementItems;
        $weight = 0;

        foreach($items as $item)
        {
            $one_weight = $net ? $item->productCard->weight_net : $item->productCard->weight;
            $weight += ($item->qnt * $one_weight);
        }

        if($kg){$weight = $weight/1000;}

        return $weight;
    }
}
