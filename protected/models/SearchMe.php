<?php

/**
 * This is the model class for table "search_me".
 *
 * The followings are the available columns in table 'search_me':
 * @property integer $id
 * @property string $email
 * @property string $trefwoord1
 * @property string $trefwoord2
 * @property string $trefwoord3
 * @property string $trefwoord4
 * @property string $zipcode
 * @property double $latitude
 * @property double $longitude
 * @property string $add_date
 */
class SearchMe extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'search_me';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('latitude, longitude,range', 'numerical'),
			array('email', 'length', 'max'=>30),
			array('trefwoord1, trefwoord2, trefwoord3, trefwoord4', 'length', 'max'=>125),
			array('zipcode', 'length', 'max'=>25),
			array('email, trefwoord1, trefwoord2, trefwoord3, trefwoord4, zipcode, latitude, longitude,range', 'safe'),
            array('email,trefwoord1', 'required','on'=>"searchMe"),
            array('email','email','message' =>'E-mail komt niet overeen formaat'),
            array('add_date','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, trefwoord1, trefwoord2, trefwoord3, trefwoord4, zipcode, latitude, longitude, add_date', 'safe', 'on'=>'search'),
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
        'userID' => array(self::BELONGS_TO, 'Users', array('email'=>'email')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
        protected function beforeSave()
        {
            if(parent::beforeSave())
            {
                $zipcode = urlencode($this->zipcode);
                        $address = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$zipcode.'&sensor=false');
                        $address = json_decode($address);
                  if($address->status == 'OK')
                        {
                                $this->latitude = $address->results[0]->geometry->location->lat;
                                $this->longitude = $address->results[0]->geometry->location->lng;
                        }
                                  
                return true;
            }
            else
                return false;
        }
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'trefwoord1' => 'Trefwoord1',
			'trefwoord2' => 'Trefwoord2',
			'trefwoord3' => 'Trefwoord3',
			'trefwoord4' => 'Trefwoord4',
			'zipcode' => 'Zipcode',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'add_date' => 'Add Date',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('trefwoord1',$this->trefwoord1,true);
		$criteria->compare('trefwoord2',$this->trefwoord2,true);
		$criteria->compare('trefwoord3',$this->trefwoord3,true);
		$criteria->compare('trefwoord4',$this->trefwoord4,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('add_date',$this->add_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SearchMe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
