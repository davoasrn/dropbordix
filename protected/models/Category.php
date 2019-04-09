<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property integer $type_id
 * @property integer $status
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $user_id
 * @property string $add_date
 * @property string $change_date
 * @property string $price
 *
 * The followings are the available model relations:
 * @property AutoDetail[] $autoDetails
 * @property Files[] $files
 * @property LibTypes $type
 */
class Category extends CActiveRecord
{
    
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type_id, status, start_date, end_date, add_date, price', 'required'),
			array('type_id, status, user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('price', 'length', 'max'=>10),
			array('description, change_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type_id, status, description, start_date, end_date, user_id, add_date, change_date, price', 'safe', 'on'=>'search'),
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
			'autoDetails' => array(self::HAS_MANY, 'AutoDetail', 'category_id'),
			'files' => array(self::HAS_MANY, 'Files', 'category_id'),
			'type' => array(self::BELONGS_TO, 'LibTypes', 'type_id'),
			'status' => array(self::BELONGS_TO, 'LibCategoryStatus', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'name' => 'Announcement name',
			'type_id' => 'Type',
			'status' => 'Status-in what process is user category',
			'description' => 'long description',
			'start_date' => 'Start to sale',
			'end_date' => 'Sale end date',
			'user_id' => 'User who added this announcement',
			'add_date' => 'Adding date',
			'change_date' => 'Update date',
			'price' => 'category price',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('change_date',$this->change_date,true);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function beforeSave()
        {
            if(parent::beforeSave())
            {
                if($this->isNewRecord)
                {
                    $this->add_date = date('Y-m-d H:m:i');
                    if(empty($this->user_id))
                        $this->user_id = Yii::app()->user->getId();
                }
               
                return true;
            }
            else
                return false;
        }
}
