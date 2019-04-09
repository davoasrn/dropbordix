<?php

/**
 * This is the model class for table "auto_detail".
 *
 * The followings are the available columns in table 'auto_detail':
 * @property integer $id
 * @property integer $announcement_id
 * @property integer $seats
 * @property string $year
 * @property string $mileage
 * @property integer $transmission_id
 * @property integer $fuel_id
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property LibFuelTypes $fuel
 * @property LibTransmission $transmission
 */
class AutoDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auto_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('announcement_id, seats, year, mileage, transmission_id, fuel_id', 'required','on' => 'create'),
			//array('seats, year, mileage, transmission_id, fuel_id', 'required','on' => 'notLogined'),
			array('announcement_id, seats, transmission_id, fuel_id', 'numerical', 'integerOnly'=>true),
			array('year', 'length', 'max'=>4),
			array('mileage', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, announcement_id, seats, year, mileage, transmission_id, fuel_id', 'safe', 'on'=>'search'),
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
			'announcement' => array(self::BELONGS_TO, 'Announcement', 'announcement_id'),
			'fuel' => array(self::BELONGS_TO, 'LibFuelTypes', 'fuel_id'),
			'transmission' => array(self::BELONGS_TO, 'LibTransmission', 'transmission_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'announcement_id' => 'Announcement',
			'seats' => 'Plaats in rubriek',
			'year' => 'Bouwjaar:',
			'mileage' => 'Km stand',
			'transmission_id' => 'Transmissie',
			'fuel_id' => 'Brandstof',
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
                $criteria->with = array('announcement');
		$criteria->compare('id',$this->id);
		$criteria->compare('`announcement`.`name`',$this->announcement_id,true);
		$criteria->compare('seats',$this->seats);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('mileage',$this->mileage,true);
		$criteria->compare('transmission_id',$this->transmission_id,true);
		$criteria->compare('fuel_id',$this->fuel_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AutoDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
