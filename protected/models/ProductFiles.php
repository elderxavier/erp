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
     * Creates product-file records in db, and saves files. Takes array of uploaded files and id of product card
     * @param $files
     * @param $product_card_id
     */
    public function saveFiles($files,$product_card_id)
    {
        /* @var $file_obj CUploadedFile */

        //pass through all array of file-params
        foreach($files as $index => $file_obj)
        {
            //if got file
            if($file_obj->size > 0)
            {
                $new_name = uniqid('pr_').'.'.$file_obj->extensionName;

                if($file_obj->saveAs('uploaded/product_files/'.$new_name))
                {
                    $file = new ProductFiles();
                    $file -> product_card_id = $product_card_id;
                    $file -> filename = $new_name;
                    $file -> label = $file_obj->name;
                    $file -> save();
                }
            }
        }
    }
}
