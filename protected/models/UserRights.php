<?php

/**
 * This is the model class for table "user_rights".
 *
 * The followings are the available columns in table 'user_rights':
 * @property integer $id
 * @property integer $users_see
 * @property integer $users_create
 * @property integer $users_delete
 * @property integer $users_edit
 * @property integer $invoices_in_see
 * @property integer $invoices_in_make
 * @property integer $invoices_out_see
 * @property integer $invoices_out_make
 * @property integer $products_see
 * @property integer $products_cards_create
 * @property integer $products_cards_edit
 * @property integer $products_cards_delete
 * @property integer $products_categories_create
 * @property integer $products_categories_edit
 * @property integer $products_categories_delete
 * @property integer $stock_see
 * @property integer $stock_operate
 * @property integer $contractors_see
 * @property integer $suppliers_see
 * @property integer $clients_see
 * @property integer $clients_create
 * @property integer $clients_delete
 * @property integer $clients_edit
 * @property integer $suppliers_create
 * @property integer $suppliers_delete
 * @property integer $suppliers_edit
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class UserRights extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_see, users_create, users_delete, users_edit, invoices_in_see, invoices_in_make, invoices_out_see, invoices_out_make, products_see, products_cards_create, products_cards_edit, products_cards_delete, products_categories_create, products_categories_edit, products_categories_delete, stock_see, stock_operate, contractors_see, suppliers_see, clients_see, clients_create, clients_delete, clients_edit, suppliers_create, suppliers_delete, suppliers_edit', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, users_see, users_create, users_delete, users_edit, invoices_in_see, invoices_in_make, invoices_out_see, invoices_out_make, products_see, products_cards_create, products_cards_edit, products_cards_delete, products_categories_create, products_categories_edit, products_categories_delete, stock_see, stock_operate, contractors_see, suppliers_see, clients_see, clients_create, clients_delete, clients_edit, suppliers_create, suppliers_delete, suppliers_edit', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'Users', 'rights_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users_see' => 'Users See',
			'users_create' => 'Users Create',
			'users_delete' => 'Users Delete',
			'users_edit' => 'Users Edit',
			'invoices_in_see' => 'Invoices In See',
			'invoices_in_make' => 'Invoices In Make',
			'invoices_out_see' => 'Invoices Out See',
			'invoices_out_make' => 'Invoices Out Make',
			'products_see' => 'Products See',
			'products_cards_create' => 'Products Cards Create',
			'products_cards_edit' => 'Products Cards Edit',
			'products_cards_delete' => 'Products Cards Delete',
			'products_categories_create' => 'Products Categories Create',
			'products_categories_edit' => 'Products Categories Edit',
			'products_categories_delete' => 'Products Categories Delete',
			'stock_see' => 'Stock See',
			'stock_operate' => 'Stock Operate',
			'contractors_see' => 'Contractors See',
			'suppliers_see' => 'Suppliers See',
			'clients_see' => 'Clients See',
			'clients_create' => 'Clients Create',
			'clients_delete' => 'Clients Delete',
			'clients_edit' => 'Clients Edit',
			'suppliers_create' => 'Suppliers Create',
			'suppliers_delete' => 'Suppliers Delete',
			'suppliers_edit' => 'Suppliers Edit',
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
		$criteria->compare('users_see',$this->users_see);
		$criteria->compare('users_create',$this->users_create);
		$criteria->compare('users_delete',$this->users_delete);
		$criteria->compare('users_edit',$this->users_edit);
		$criteria->compare('invoices_in_see',$this->invoices_in_see);
		$criteria->compare('invoices_in_make',$this->invoices_in_make);
		$criteria->compare('invoices_out_see',$this->invoices_out_see);
		$criteria->compare('invoices_out_make',$this->invoices_out_make);
		$criteria->compare('products_see',$this->products_see);
		$criteria->compare('products_cards_create',$this->products_cards_create);
		$criteria->compare('products_cards_edit',$this->products_cards_edit);
		$criteria->compare('products_cards_delete',$this->products_cards_delete);
		$criteria->compare('products_categories_create',$this->products_categories_create);
		$criteria->compare('products_categories_edit',$this->products_categories_edit);
		$criteria->compare('products_categories_delete',$this->products_categories_delete);
		$criteria->compare('stock_see',$this->stock_see);
		$criteria->compare('stock_operate',$this->stock_operate);
		$criteria->compare('contractors_see',$this->contractors_see);
		$criteria->compare('suppliers_see',$this->suppliers_see);
		$criteria->compare('clients_see',$this->clients_see);
		$criteria->compare('clients_create',$this->clients_create);
		$criteria->compare('clients_delete',$this->clients_delete);
		$criteria->compare('clients_edit',$this->clients_edit);
		$criteria->compare('suppliers_create',$this->suppliers_create);
		$criteria->compare('suppliers_delete',$this->suppliers_delete);
		$criteria->compare('suppliers_edit',$this->suppliers_edit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserRights the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
