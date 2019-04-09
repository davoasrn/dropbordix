<?php

/**
 * This is the model class for table "announcement_paid".
 *
 * The followings are the available columns in table 'announcement_paid':
 * @property integer $id
 * @property integer $type_id
 * @property integer $announcement_id
 * @property string $url
 * @property integer $paid
 * @property integer $user_id
 * @property string $order_id
 * @property date $add_date
 * @property date $change_date
 */
class AnnouncementPaid extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'announcement_paid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('announcement_id, type_id, order_id', 'required'),
			array('announcement_id, type_id, user_id, user_id', 'numerical', 'integerOnly'=>true),
//			array('url', 'length', 'max'=>500),
                       // array('change_date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type_id, announcement_id, url, paid, user_id, add_date, change_date, order_id', 'safe', 'on'=>'search'),
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
                    'type'  => array(self::BELONGS_TO, 'LibPaidServices', 'type_id'),
                    'statusPay'  => array(self::BELONGS_TO, 'LibPaymentStatus', 'status'),
                    'user'  => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'type_id' => 'lib_paid_service field id',
			'announcement_id' => 'Announcement id',
			'url' => 'Url for showing',
			'paid' => 'Show user paid for this action',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('add_date',$this->add_date);
		$criteria->compare('change_date',$this->change_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AnnouncementPaid the static model class
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
                        if(empty($this->user_id) && !is_null(Yii::app()->user->getId()))
                            $this->user_id = Yii::app()->user->getId();
                    }
                    $this->change_date = date('Y-m-d H:m:i');
                    return true;
                }
                else
                    return false;
        }
        
}
