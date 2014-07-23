<?php

/**
 * This is the model class for table "product_files".
 *
 * The followings are the available columns in table 'product_files':
 * @property integer $id
 * @property integer $product_card_id
 * @property string $filename
 * @property string $label
 *
 * The followings are the available model relations:
 * @property ProductCards $productCard
 */
class ProductFiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_card_id', 'numerical', 'integerOnly'=>true),
			array('filename, label', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_card_id, filename, label', 'safe', 'on'=>'search'),
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
			'productCard' => array(self::BELONGS_TO, 'ProductCards', 'product_card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_card_id' => 'Product Card',
			'filename' => 'Filename',
			'label' => 'Label',
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
		$criteria->compare('product_card_id',$this->product_card_id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('label',$this->label,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Saves files on server and creates product-file-objects in data-base
     * @param array $file_params
     * @param int $product_card_id
     */
    public function saveFiles($file_params,$product_card_id)
    {
        /* @var $file ProductFiles */

        //pass through all array of file-params
        foreach($file_params as $index => $file_arr)
        {
            //if file uploaded and no errors
            if($file_arr['error'] == 0)
            {
                //if copied successfully
                if(copy($file_arr['tmp_name'], 'uploaded/product_files/'.$file_arr['random_name']))
                {
                    $file = new ProductFiles();
                    $file -> product_card_id = $product_card_id;
                    $file -> filename = $file_arr['random_name'];
                    $file -> label = $file_arr['name'];
                    $file -> save();
                }
            }
        }
    }
}
