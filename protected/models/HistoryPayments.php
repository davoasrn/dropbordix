<?php

/**
 * This is the model class for table "history_payments".
 *
 * The followings are the available columns in table 'history_payments':
 * @property integer $history_id
 * @property integer $id
 * @property integer $announcement_id
 * @property string $sum
 * @property string $email
 * @property string $add_date
 * @property string $change_date
 * @property string $insert_date
 */
class HistoryPayments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'history_payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('announcement_id, sum, email, add_date, change_date, insert_date', 'required'),
			array('id, announcement_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'length', 'max'=>11),
			array('email', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('history_id, id, announcement_id, sum, email, add_date, change_date, insert_date', 'safe', 'on'=>'search'),
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
			'history_id' => 'Identification number',
			'id' => 'ID',
			'announcement_id' => 'for  which announcement say price',
			'sum' => 'Bid sum',
			'email' => 'Person email',
			'add_date' => 'Adding date',
			'change_date' => 'Update date',
			'insert_date' => 'history table adding date',
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

		$criteria->compare('history_id',$this->history_id);
		$criteria->compare('id',$this->id);
		$criteria->compare('announcement_id',$this->announcement_id);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('change_date',$this->change_date,true);
		$criteria->compare('insert_date',$this->insert_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoryPayments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
