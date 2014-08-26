<?php

/**
 * This is the model class for table "user_cities".
 *
 * The followings are the available columns in table 'user_cities':
 * @property integer $id
 * @property string $city_name
 * @property string $country
 * @property string $description
 * @property integer $changed_by
 *
 * The followings are the available model relations:
 * @property Stocks[] $stocks
 * @property Users[] $users
 */
class UserCities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('changed_by', 'numerical', 'integerOnly'=>true),
			array('city_name, country, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, city_name, country, description, changed_by', 'safe', 'on'=>'search'),
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
			'stocks' => array(self::HAS_MANY, 'Stocks', 'location_id'),
			'users' => array(self::HAS_MANY, 'Users', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_name' => 'City Name',
			'country' => 'Country',
			'description' => 'Description',
			'changed_by' => 'Changed By',
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
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('changed_by',$this->changed_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

 	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserCities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Returns all cities as pairs 'id'=>'name'
     * @return array
     */
    public function findAllAsArray()
    {
        /* @var $city UserCities */

        //declare empty array
        $arr = array();

        //get all
        $all = UserCities::model()->findAll();

        //make array
        foreach($all as $city)
        {
            $arr[$city->id] = $city->city_name;
        }

        return $arr;
    }
}
