<?php

/**
 * This is the model class for table "suppliers".
 *
 * The followings are the available columns in table 'suppliers':
 * @property integer $id
 * @property string $company_name
 * @property string $company_code
 * @property string $vat_code
 * @property string $phones
 * @property string $phone1
 * @property string $phone2
 * @property string $emails
 * @property string $email1
 * @property string $email2
 * @property string $remark
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 * @property integer $status
 * @property string $address
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $building_nr
 * @property string $contract_number
 *
 * The followings are the available model relations:
 * @property InvoicesIn[] $invoicesIns
 */
class Suppliers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suppliers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_created, date_changed, user_modified_by, status', 'numerical', 'integerOnly'=>true),
			array('address, country, city, street, building_nr, contract_number', 'length', 'max'=>255),
			array('company_name, company_code, vat_code, phones, phone1, phone2, emails, email1, email2, remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_name, company_code, vat_code, phones, phone1, phone2, emails, email1, email2, remark, date_created, date_changed, user_modified_by, status, address, country, city, street, building_nr, contract_number', 'safe', 'on'=>'search'),
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
			'invoicesIns' => array(self::HAS_MANY, 'InvoicesIn', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_name' => 'Company Name',
			'company_code' => 'Company Code',
			'vat_code' => 'Vat Code',
			'phones' => 'Phones',
			'phone1' => 'Phone1',
			'phone2' => 'Phone2',
			'emails' => 'Emails',
			'email1' => 'Email1',
			'email2' => 'Email2',
			'remark' => 'Remark',
			'date_created' => 'Date Created',
			'date_changed' => 'Date Changed',
			'user_modified_by' => 'User Modified By',
			'status' => 'Status',
			'address' => 'Address',
			'country' => 'Country',
			'city' => 'City',
			'street' => 'Street',
			'building_nr' => 'Building Nr',
			'contract_number' => 'Contract Number',
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_code',$this->company_code,true);
		$criteria->compare('vat_code',$this->vat_code,true);
		$criteria->compare('phones',$this->phones,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('emails',$this->emails,true);
		$criteria->compare('email1',$this->email1,true);
		$criteria->compare('email2',$this->email2,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('user_modified_by',$this->user_modified_by);
		$criteria->compare('status',$this->status);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('building_nr',$this->building_nr,true);
		$criteria->compare('contract_number',$this->contract_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Suppliers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getAllClientsJson($suppName =  null)
    {
        if(!empty($suppName)){
            $companyName = trim($suppName);
            $result = array();
            //sql statement
            $sql = "SELECT * FROM `".$this->tableName()."` WHERE company_name LIKE '%".$companyName."%'";
            $con = $this->dbConnection;
            //get all data by query
            $data=$con->createCommand($sql)->queryAll(true);
            //foreach row
            foreach($data as $row)
            {
                //add to result array
                $result[] = array( 'label' => $row['company_name'] ,'id' => $row['id']);
            }
            return json_encode($result);
        }
        return json_encode(array());
    }//getAllClientsJson


    public function getSeller($name = null)
    {
        $arrRow = array();
        if(!empty($name)){
            $companyName = trim($name);
            $con = $this->dbConnection;
            $sql = "SELECT * FROM `".$this->tableName()."` WHERE company_name LIKE '".$companyName."'";
            $data=$con->createCommand($sql)->query();

            foreach($data as $row)
            {
                $arrRow[] = $row;
            }
        }
        return $arrRow;
    }//getClients
}
