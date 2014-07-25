<?php

/**
 * This is the model class for table "service_processes".
 *
 * The followings are the available columns in table 'service_processes':
 * @property integer $id
 * @property string $label
 * @property string $remark
 * @property integer $start_date
 * @property integer $close_date
 * @property integer $client_id
 * @property integer $status
 * @property integer $operation_id
 * @property integer $problem_type_id
 * @property integer $date_created
 * @property integer $date_changed
 * @property integer $user_modified_by
 *
 * The followings are the available model relations:
 * @property OperationsSrv[] $operationsSrvs
 * @property OperationsOut $operation
 * @property Clients $client
 * @property ServiceProblemTypes $problemType
 * @property ServiceResolutions[] $serviceResolutions
 */
class ServiceProcesses extends CActiveRecord
{

    /**
     * Service statuses
     */
    const ST_OPENED = 0;
    const ST_IN_PROGRESS = 1;
    const ST_CLOSED = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_processes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date, close_date, client_id, status, operation_id, problem_type_id, date_created, date_changed, user_modified_by', 'numerical', 'integerOnly'=>true),
			array('label, remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, remark, start_date, close_date, client_id, status, operation_id, problem_type_id, date_created, date_changed, user_modified_by', 'safe', 'on'=>'search'),
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
			'operationsSrvs' => array(self::HAS_MANY, 'OperationsSrv', 'service_process_id'),
			'operation' => array(self::BELONGS_TO, 'OperationsOut', 'operation_id'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'problemType' => array(self::BELONGS_TO, 'ServiceProblemTypes', 'problem_type_id'),
			'serviceResolutions' => array(self::HAS_MANY, 'ServiceResolutions', 'service_process_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'remark' => 'Remark',
			'start_date' => 'Start Date',
			'close_date' => 'Close Date',
			'client_id' => 'Client',
			'status' => 'Status',
			'operation_id' => 'Operation',
			'problem_type_id' => 'Problem Type',
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
		$criteria->compare('label',$this->label,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('start_date',$this->start_date);
		$criteria->compare('close_date',$this->close_date);
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('operation_id',$this->operation_id);
		$criteria->compare('problem_type_id',$this->problem_type_id);
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
	 * @return ServiceProcesses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Returns current status as text label
     * @return string
     */
    public function statusLabel()
    {
        $arr[self::ST_CLOSED] = 'finished';
        $arr[self::ST_IN_PROGRESS] = 'in progress';
        $arr[self::ST_OPENED] = 'opened';

        return (string)$arr[$this->status];
    }
}
