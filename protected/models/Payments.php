<?php

/**
 * This is the model class for table "payments".
 *
 * The followings are the available columns in table 'payments':
 * @property integer $id
 * @property integer $announcement_id
 * @property string $sum
 * @property string $email
 * @property string $add_date
 * @property string $change_date
 */
class Payments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('announcement_id, sum, email', 'required'),
			array('announcement_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'length', 'max'=>11),
			array('email', 'length', 'max'=>255),
			array('email', 'email'),
                        array('sum','checkSum'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, announcement_id, sum, email, add_date, change_date', 'safe', 'on'=>'search'),
		);
	}
        
        /*
         * check sum for bigger tyhan last payment
         */
        public function checkSum($attribute){
            if(isset($this->$attribute) && !empty($this->$attribute)){
                $announcement = Announcement::model()->findByPk($this->announcement_id);
                if(isset($announcement->bid) && (int)$announcement->bid < $this->sum)
                    $this->addError($attribute,'Uw betaling kan niet kleiner zijn dan de aankondiging provide prijs');
                
                $lastPay = Payments::model()->findByAttributes(array('announcement_id' => $this->announcement_id),array('order'=>'add_date desc'));
                if(isset($lastPay) && $this->sum <= $lastPay->sum)
                    $this->addError($attribute,'Uw betaling kan niet kleiner zijn dan laatste betaling voor deze aankondiging zijn');
            }
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'announcement' => array(self::BELONGS_TO,'Announcement','announcement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'announcement_id' => 'for  which announcement say price',
			'sum' => 'Uw bod (boven €3000,-):',
			'email' => 'E-mail adres:',
			'add_date' => 'Adding date',
			'change_date' => 'Update date',
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
                $criteria->compare('`announcement`.`name`',$this->announcement_id,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('change_date',$this->change_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payments the static model class
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
                }
        	$this->change_date = date('Y-m-d H:m:i');
                return true;
            }
            else
                return false;
    }
}
