<?php

/**
 * This is the model class for table "clients".
 *
 * The followings are the available columns in table 'clients':
 * @property integer $id
 * @property string $name
 * @property string $company_name
 * @property string $surname
 * @property string $personal_code
 * @property string $company_code
 * @property string $vat_code
 * @property integer $first_invoice_id
 * @property integer $last_invoice_id
 * @property string $phones
 * @property string $phone1
 * @property string $phone2
 * @property string $emails
 * @property string $email1
 * @property string $email2
 * @property string $remark
 * @property string $remark_for_service
 * @property integer $last_service_id
 * @property integer $next_service_id
 * @property integer $last_service_date
 * @property integer $next_service_date
 * @property integer $type
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 * @property integer $priority
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property InvoicesOut $firstInvoice
 * @property InvoicesOut $lastInvoice
 * @property InvoicesOut[] $invoicesOuts
 * @property ServiceProcesses[] $serviceProcesses
 */
class Clients extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_invoice_id, last_invoice_id, last_service_id, next_service_id, last_service_date, next_service_date, type, date_created, date_changed, user_modified_by, priority, status', 'numerical', 'integerOnly'=>true),
			array('name, company_name, surname, personal_code, company_code, vat_code, phones, phone1, phone2, emails, email1, email2, remark, remark_for_service', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, company_name, surname, personal_code, company_code, vat_code, first_invoice_id, last_invoice_id, phones, phone1, phone2, emails, email1, email2, remark, remark_for_service, last_service_id, next_service_id, last_service_date, next_service_date, type, date_created, date_changed, user_modified_by, priority, status', 'safe', 'on'=>'search'),
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
			'firstInvoice' => array(self::BELONGS_TO, 'InvoicesOut', 'first_invoice_id'),
			'lastInvoice' => array(self::BELONGS_TO, 'InvoicesOut', 'last_invoice_id'),
			'invoicesOuts' => array(self::HAS_MANY, 'InvoicesOut', 'client_id'),
			'serviceProcesses' => array(self::HAS_MANY, 'ServiceProcesses', 'client_id'),
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
			'company_name' => 'Company Name',
			'surname' => 'Surname',
			'personal_code' => 'Personal Code',
			'company_code' => 'Company Code',
			'vat_code' => 'Vat Code',
			'first_invoice_id' => 'First Invoice',
			'last_invoice_id' => 'Last Invoice',
			'phones' => 'Phones',
			'phone1' => 'Phone1',
			'phone2' => 'Phone2',
			'emails' => 'Emails',
			'email1' => 'Email1',
			'email2' => 'Email2',
			'remark' => 'Remark',
			'remark_for_service' => 'Remark For Service',
			'last_service_id' => 'Last Service',
			'next_service_id' => 'Next Service',
			'last_service_date' => 'Last Service Date',
			'next_service_date' => 'Next Service Date',
			'type' => 'Type',
			'date_created' => 'Date Created',
			'date_changed' => 'Date Changed',
			'user_modified_by' => 'User Modified By',
			'priority' => 'Priority',
			'status' => 'Status',
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('personal_code',$this->personal_code,true);
		$criteria->compare('company_code',$this->company_code,true);
		$criteria->compare('vat_code',$this->vat_code,true);
		$criteria->compare('first_invoice_id',$this->first_invoice_id);
		$criteria->compare('last_invoice_id',$this->last_invoice_id);
		$criteria->compare('phones',$this->phones,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('emails',$this->emails,true);
		$criteria->compare('email1',$this->email1,true);
		$criteria->compare('email2',$this->email2,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('remark_for_service',$this->remark_for_service,true);
		$criteria->compare('last_service_id',$this->last_service_id);
		$criteria->compare('next_service_id',$this->next_service_id);
		$criteria->compare('last_service_date',$this->last_service_date);
		$criteria->compare('next_service_date',$this->next_service_date);
		$criteria->compare('type',$this->type);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_changed',$this->date_changed);
		$criteria->compare('user_modified_by',$this->user_modified_by);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Returns all clients as pairs 'id'=>'name'
     * @return array
     */
    public function findAllAsArray()
    {
        /* @var $client Clients */

        //declare empty array
        $arr = array();

        //get all
        $all = Clients::model()->findAll();

        //make array
        foreach($all as $client)
        {
            $arr[$client->id] = ($client->type == 1 ? $client->company_name : $client->name.' '.$client->surname);
        }

        return $arr;
    }


    /**
     * Takes name's surname's or company-name's start fragment, type of client and returns array of variants
     * @param string $start
     * @param int $type
     * @return array
     */
    public function getClientsByNameParts($start,$type)
    {
        //declare empty array
        $result = array();

        //explode string to words
        $words = explode(" ",$start, 2);

        //if juridical client-type
        if($type == 1)
        {
            $sql = "SELECT * FROM clients WHERE company_name LIKE '%".$start."%'";
        }
        //if physical client-type
        else
        {
            //if given two words
            if(count($words) > 1)
            {
                //sql statement
                $sql = "SELECT * FROM clients WHERE (`name` LIKE '%".$words[0]."%') AND (`surname` LIKE '%".$words[1]."%')";
            }
            //if just one word
            else
            {
                //sql statement
                $sql = "SELECT * FROM clients WHERE name LIKE '%".$start."%'";
            }
        }

        //connection
        $con = Yii::app()->db;

        //get all data by query
        $data=$con->createCommand($sql)->queryAll();

        //foreach row
        foreach($data as $row)
        {
            //add to result array
            $result[] = array('label' => $row['type'] == 1 ? $row['company_name']: $row['name'].' '.$row['surname'], 'id' => $row['id']);
        }

        return $result;
    }


    /**
     * Takes the star-fragments of name and surname, type and returns array of clients
     * @param string $name
     * @param int $type
     * @return array
     */
    public function findClientsByNames($name,$type)
    {
        //get array of separated-by-spaces words
        $words = explode(" ",$name,2);

        //if juridical client-type
        if($type == 1)
        {
            $sql = "SELECT * FROM clients WHERE company_name LIKE '%".$name."%'";
        }
        //if physical client-type
        else
        {
            //if given two words
            if(count($words) > 1)
            {
                //sql statement
                $sql = "SELECT * FROM clients WHERE (`name` LIKE '%".$words[0]."%') AND (`surname` LIKE '%".$words[1]."%')";
            }
            //if just one word
            else
            {
                //sql statement
                $sql = "SELECT * FROM clients WHERE name LIKE '%".$name."%'";
            }
        }

        //connection
        $con = Yii::app()->db;

        //get rows if name was not empty by query
        $name != '' ? $data=$con->createCommand($sql)->queryAll() : $data = array();

        return $data;
    }

    /**
     * Returns array of clients
     * @param string $code
     * @param int $type
     * @return array
     */
    public function findClientsByCode($code,$type)
    {
        $type == 1 ? $sql = "SELECT * FROM clients WHERE company_code LIKE '%".$code."%'" : $sql = "SELECT * FROM clients WHERE personal_code LIKE '%".$code."%'";
        //connection
        $con = Yii::app()->db;
        //get rows if parameter not empty
        $code != '' ? $data=$con->createCommand($sql)->queryAll() : $data = array();

        return $data;
    }

    /**
     * Returns one record-row from table by id
     * @param int $id
     * @return mixed
     */
    public function getOneRowByPk($id)
    {
        $sql = "SELECT * FROM clients WHERE id = '".$id."'";
        $con = Yii::app()->db;
        $data = $con->createCommand($sql)->queryRow();

        return $data;
    }

    /**
     * Returns name or company name
     * @return string
     */
    public function getFullName()
    {
        return $this->type == 1 ? $this->company_name : $this->name.' '.$this->surname;
    }

    /**
     * Returns label of client's type
     * @return string
     */
    public function getTypeName()
    {
        return $this->type == 1 ? 'juridical' : 'physical';
    }

    /**
     * Returns personal or company code
     * @return string
     */
    public function getActiveCode()
    {
        return $this->type == 1 ? $this->company_code : $this->personal_code;
    }
}
