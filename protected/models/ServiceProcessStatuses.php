<?php

/**
 * This is the model class for table "service_process_statuses".
 *
 * The followings are the available columns in table 'service_process_statuses':
 * @property integer $id
 * @property string $status_name
 * @property string $system_id
 * @property integer $system
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property ServiceProcesses[] $serviceProcesses
 */
class ServiceProcessStatuses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_process_statuses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system, priority', 'numerical', 'integerOnly'=>true),
			array('status_name, system_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status_name, system_id, system, priority', 'safe', 'on'=>'search'),
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
			'serviceProcesses' => array(self::HAS_MANY, 'ServiceProcesses', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status_name' => 'Status Name',
			'system_id' => 'System',
			'system' => 'System',
			'priority' => 'Priority',
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
		$criteria->compare('status_name',$this->status_name,true);
		$criteria->compare('system_id',$this->system_id,true);
		$criteria->compare('system',$this->system);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceProcessStatuses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Returns id of system status by it's system-id (system-label)
     * @param $systemId
     * @return int
     */
    public function systemStatusId($systemId)
    {
        /* @var $status ServiceProcessStatuses */
        $status = self::model()->findByAttributes(array('system_id' => $systemId));

        if($status) return $status->id;
        else return 0;
    }

    /**
     * Returns name of status by it's id
     * @param $id
     * @return int|string
     */
    public function getNameById($id)
    {
        /* @var $status ServiceProcessStatuses */
        $status = self::model()->findByPk($id);

        if($status) return $status->status_name;
        else return 0;
    }
}
