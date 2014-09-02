<?php

/**
 * This is the model class for table "operations_out".
 *
 * The followings are the available columns in table 'operations_out':
 * @property integer $id
 * @property string $invoice_code
 * @property integer $warranty_start_date
 * @property integer $payment_method_id
 * @property string $signer_name
 * @property integer $client_id
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 * @property integer $vat_id
 * @property integer $invoice_date
 * @property integer $stock_id
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property Clients[] $clients
 * @property Clients[] $clients1
 * @property Clients $client
 * @property PaymentMethods $paymentMethod
 * @property Vat $vat
 * @property Stocks $stock
 * @property OperationOutStatuses $status
 * @property OperationsOutItems[] $operationsOutItems
 * @property OperationsOutOptItems[] $operationsOutOptItems
 * @property OperationsSrvItems[] $operationsSrvItems
 */
class OperationsOut extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations_out';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warranty_start_date, payment_method_id, client_id, date_created, date_changed, user_modified_by, vat_id, invoice_date, stock_id, status_id', 'numerical', 'integerOnly'=>true),
			array('invoice_code, signer_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_code, warranty_start_date, payment_method_id, signer_name, client_id, date_created, date_changed, user_modified_by, vat_id, invoice_date, stock_id, status_id', 'safe', 'on'=>'search'),
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
			'clients' => array(self::HAS_MANY, 'Clients', 'first_invoice_id'),
			'clients1' => array(self::HAS_MANY, 'Clients', 'last_invoice_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethods', 'payment_method_id'),
			'vat' => array(self::BELONGS_TO, 'Vat', 'vat_id'),
			'stock' => array(self::BELONGS_TO, 'Stocks', 'stock_id'),
			'status' => array(self::BELONGS_TO, 'OperationOutStatuses', 'status_id'),
			'operationsOutItems' => array(self::HAS_MANY, 'OperationsOutItems', 'operation_id'),
			'operationsOutOptItems' => array(self::HAS_MANY, 'OperationsOutOptItems', 'operation_id'),
			'operationsSrvItems' => array(self::HAS_MANY, 'OperationsSrvItems', 'operaion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_code' => 'Invoice Code',
			'warranty_start_date' => 'Warranty Start Date',
			'payment_method_id' => 'Payment Method',
			'signer_name' => 'Signer Name',
			'client_id' => 'Client',
			'date_created' => 'Date Created',
			'date_changed' => 'Date Changed',
			'user_modified_by' => 'User Modified By',
			'vat_id' => 'Vat',
			'invoice_date' => 'Invoice Date',
			'stock_id' => 'Stock',
			'status_id' => 'Status',
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
		$criteria->compare('invoice_code',$this->invoice_code,true);
		$criteria->compare('warranty_start_date',$this->warranty_start_date);
		$criteria->compare('payment_method_id',$this->payment_method_id);
		$criteria->compare('signer_name',$this->signer_name,true);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('user_modified_by',$this->user_modified_by);
		$criteria->compare('vat_id',$this->vat_id);
		$criteria->compare('invoice_date',$this->invoice_date);
		$criteria->compare('stock_id',$this->stock_id);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperationsOut the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Calculates total price of all items (including options)
     * @param bool $with_vat
     * @return float|int
     */
    public function calculateTotalPrice($with_vat = true)
    {
        $total_sum = 0;

        foreach($this->operationsOutItems as $prod_item)
        {
            $total_sum += ($prod_item->price - ($prod_item->price * ($prod_item->discount_percent/100)))*$prod_item->qnt;
        }
        foreach($this->operationsOutOptItems as $opt_item)
        {
            $total_sum += $opt_item->price;
        }

        if($with_vat)
        {
            $total_sum += ($total_sum * $this->vat->percent/100);
        }

        return $total_sum;
    }
}
