<?php

/**
 * This is the model class for table "lib_types".
 *
 * The followings are the available columns in table 'lib_types':
 * @property integer $id
 * @property string $name
 * @property string $merchant_id
 * @property string $security_key
 * @property string $security_key_version
 * @property string $video_price
 * @property string $site_url_price
 *
 * The followings are the available model relations:
 * @property Goods[] $goods
 */
class LibOmnikassa extends CActiveRecord
{
    
        public  $status_production = 1,
                $status_test = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lib_omnikassa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, merchant_id, security_key, security_key_version, video_price, site_url_price, status', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, merchant_id, security_key, security_key_version, video_price, site_url_price', 'safe', 'on'=>'search'),
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
			'id' => 'Identification number',
			'name' => 'Name',
			'merchant_id' => 'Merchant id',
			'security_key' => 'Secret Key',
			'security_key_version' => 'Secret key version',
			'video_price' => 'Video showing price',
			'site_url_price' => 'Site url showing price',
			'status' => 'Status',// 0- production(default), 1- test (test)
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
		$criteria->compare('merchant_id',$this->merchant_id,true);
		$criteria->compare('security_key',$this->security_key,true);
		$criteria->compare('security_key_version',$this->security_key_version,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function afterSave() {
            parent::afterSave();
            if($this->status == 1){
                self::model()->updateAll(array('status'=>0),'id !="'.$this->id.'"');
            }
        }
        
}
