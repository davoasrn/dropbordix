<?php

/**
 * This is the model class for table "lib_posts".
 *
 * The followings are the available columns in table 'lib_posts':
 * @property integer $id
 * @property string $country_code
 * @property string $postal_code
 * @property string $place_name
 * @property string $state
 * @property string $state_code
 * @property string $province
 * @property string $province_code
 * @property string $community
 * @property string $communit_code
 * @property string $latitude
 * @property string $longitude
 * @property string $lat_lag
 */
class LibPosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lib_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_code, postal_code, place_name, state, state_code, province, province_code, community, communit_code, latitude, longitude, lat_lag', 'required'),
			array('country_code, postal_code, place_name, state, state_code, province, province_code, community, communit_code, latitude, longitude, lat_lag', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_code, postal_code, place_name, state, state_code, province, province_code, community, communit_code, latitude, longitude, lat_lag', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'identificatio number',
			'country_code' => 'country code',
			'postal_code' => 'postal code',
			'place_name' => 'place name',
			'state' => 'state',
			'state_code' => 'state code',
			'province' => 'province',
			'province_code' => 'province code',
			'community' => 'community',
			'communit_code' => 'community code',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'lat_lag' => 'Lat Lag',
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
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('place_name',$this->place_name,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('state_code',$this->state_code,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('province_code',$this->province_code,true);
		$criteria->compare('community',$this->community,true);
		$criteria->compare('communit_code',$this->communit_code,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('lat_lag',$this->lat_lag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibPosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
}
