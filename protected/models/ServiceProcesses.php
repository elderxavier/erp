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
 * @property string $priority
 * @property integer $current_employee_id
 *
 * The followings are the available model relations:
 * @property OperationsSrv[] $operationsSrvs
 * @property Users $userModifiedBy
 * @property Clients $client
 * @property OperationsOut $operation
 * @property ServiceProblemTypes $problemType
 * @property Users $currentEmployee
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
			array('start_date, close_date, client_id, status, operation_id, problem_type_id, date_created, date_changed, user_modified_by, current_employee_id', 'numerical', 'integerOnly'=>true),
			array('label, remark, priority', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, remark, start_date, close_date, client_id, status, operation_id, problem_type_id, date_created, date_changed, user_modified_by, priority, current_employee_id', 'safe', 'on'=>'search'),
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
			'userModifiedBy' => array(self::BELONGS_TO, 'Users', 'user_modified_by'),
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id'),
			'operation' => array(self::BELONGS_TO, 'OperationsOut', 'operation_id'),
			'problemType' => array(self::BELONGS_TO, 'ServiceProblemTypes', 'problem_type_id'),
			'currentEmployee' => array(self::BELONGS_TO, 'Users', 'current_employee_id'),
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
			'priority' => 'Priority',
			'current_employee_id' => 'Current Employee',
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
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('current_employee_id',$this->curren_employee_id);

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


    /**
     * Returns formatted time value, takes string of format like 'months.weeks.days.hours.minutes.seconds' or 'hours.minutes'
     * @param string $format
     * @return mixed
     */
    public function timeLeft($format)
    {
        //declare empty result
        $result = $format;

        $sec_in_min = 60; //one minute
        $sec_in_hour = 60 * $sec_in_min; //one hour
        $sec_in_day = 24 * $sec_in_hour; //one day
        $sec_in_week = $sec_in_day * 7; //one week
        $sec_in_month = $sec_in_week * 4; //month

        //current time in seconds
        $current_time = time();

        //close time in seconds
        $close_time = $this->close_date;

        //time left
        $seconds_left = $close_time - $current_time;
        $months_left = 0;
        $weeks_left = 0;
        $days_left = 0;
        $hours_left = 0;
        $minutes_left = 0;

        //if time has gone into negative - left 0 seconds
        if($seconds_left < 0) $seconds_left = 0;

        //store all seconds as residue
        $residue = $seconds_left;

        //if time is positive
        if($seconds_left > 0)
        {
            //if word 'moths' exist in format-string
            if(strstr($format,'moths'))
            {
                //calculate months
                $months_left = (int)($residue/$sec_in_month); //get integral part of of division
                $residue -= ($months_left * $sec_in_month); //recalculate residue
            }

            //if word 'weeks' exist in format-string
            if(strstr($format,'weeks'))
            {
                //calculate weeks
                $weeks_left = (int)($residue/$sec_in_week); //get integral part of of division
                $residue -= ($weeks_left * $sec_in_week); //recalculate residue
            }

            //if word 'days' exist in format-string
            if(strstr($format, 'days'))
            {
                //calculate days
                $days_left = (int)($residue/$sec_in_day); //get integral part of of division
                $residue -= ($days_left * $sec_in_day); //recalculate residue
            }

            //if word 'hours' exist in format-string
            if(strstr($format, 'hours'))
            {
                //calculate hours
                $hours_left = (int)($residue/$sec_in_hour); //get integral part of of division
                $residue -= ($hours_left * $sec_in_hour); //recalculate residue
            }

            //if word 'minutes' exist in format-string
            if(strstr($format, 'minutes'))
            {
                //calculate minutes
                $minutes_left = (int)($residue/$sec_in_min); //get integral part of of division
                $residue -= ($minutes_left * $sec_in_min); //recalculate residue
            }

            //seconds left after all
            $seconds_left = $residue;
        }


        //replace words in format-string with real values
        $result = str_replace('months',$months_left,$result);
        $result = str_replace('weeks',$weeks_left,$result);
        $result = str_replace('days',$days_left,$result);
        $result = str_replace('hours',$hours_left,$result);
        $result = str_replace('minutes',$minutes_left,$result);
        $result = str_replace('seconds',$seconds_left,$result);

        //result
        return $result;

    }

}
