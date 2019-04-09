<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $postal_code
 * @property string $postal_code_letter
 * @property string $phone
 * @property string $photo
 * @property string $password
 * @property integer $type
 * @property integer $facebook_id
 * @property string $add_date
 * @property string $change_date
 */
class Users extends CActiveRecord
{
        public $repeat_password;
        const ROLE_ADMIN = 1;
        
        const ROLE_USER_NOT_LOGINED = 2;
        const ROLE_USER = 0;
        //const ROLE_BANNED = 'banned';
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, postal_code, postal_code_letter, password', 'required', 'on' => 'create'),
			array('name, email, postal_code, postal_code_letter', 'required', 'on' => 'notLogined'),
			array('name, facebook_id', 'required', 'on' => 'social'),
                        array('repeat_password', 'required', 'on'=>'create'),
			array('postal_code, type', 'numerical', 'integerOnly'=>true),
			array('name, email, phone, photo, password', 'length', 'max'=>255),
			array('postal_code_letter', 'length', 'max'=>2),
                        array('email', 'email','message'=>"The email isn't correct"),
			//array('photo', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1048576, 'on' => 'notLogined'),
                        array('email', 'unique','message'=>'Email already exists!','on' => 'create'),  
			array('email', 'uniqueUpdate', 'on' => 'update'),
                        array('repeat_password,latitude,longitude','safe'),
                        //array('password, repeat_password', 'length', 'min'=>6, 'max'=>40),
                        array('password', 'compare', 'compareAttribute'=>'repeat_password'/*, 'on'=>'register'*/),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, postal_code, facebook_id, postal_code_letter, phone, photo, password, type, add_date', 'safe', 'on'=>'search'),
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
                    'savedAnn' => array(self::HAS_MANY, 'SavedAnnouncements','user_id'),
                    'postalCode' => array(self::BELONGS_TO, 'LibPosts', array('postal_code' => 'postal_code')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identification number',
			'name' => 'Uw naam op Dropbord.nl',//'User name',
			'email' => 'Emailadres:',//'User email',
			'postal_code' => 'Postcode:',//'Postal code, no letters',
			'postal_code_letter' => 'Postal code, only letters',
			'phone' => 'Telefoonnummer',//'User phone number',
			'photo' => 'User photo',
			'password' => 'Wachtwoord:',//'User passsword',
			'repeat_password' => 'Herhaal wachtwoord:',//'repeat passsword',
			'type' => 'User type',
			'facebook_id' => 'Facebook',
			'add_date' => 'User registration date',
			'change_date' => 'Profile update date',
		);
	}
	
	/*
	*check if email is unqiue if it changed in update operation
	*/
	public function uniqueUpdate($attribute){
		if(isset($this->id) && !empty($this->id)){
			$user = Users::model()->findByPk($this->id);
			if(isset($user) && $user->email != $this->$attribute){
				$countEmail = Users::model()->countByAttributes(array('email' => $this->$attribute));
				if($countEmail > 0)
					$this->addError($this->$attribute,'Email already exists!');
			}
		}
	}
        
        /*
         * check if password and repeat_password are filled correctly
         */
        public function checkPassword(){
            
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('postal_code',$this->postal_code);
		$criteria->compare('postal_code_letter',$this->postal_code_letter,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('facebook_id',$this->facebook_id);
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
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function beforeSave()
        {
            if(parent::beforeSave())
            {
                $zipcode = urlencode($this->postal_code." ".$this->postal_code_letter);
                        $address = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$zipcode.'&sensor=false');
                        $address = json_decode($address);
                  if($address->status == 'OK')
                        {
                                $this->latitude = $address->results[0]->geometry->location->lat;
                                $this->longitude = $address->results[0]->geometry->location->lng;
                        }
						
                                
                if(!empty($this->password))
                        $this->password = CPasswordHelper::hashPassword($this->password);
                
                if($this->isNewRecord)
                {
                    $this->add_date = date('Y-m-d H:m:i');
                    
                }else{
                    $user = $this->model()->findbyPk($this->id);
                    if(empty($this->password))
                        $this->password = $user->password;
                    if(empty($this->photo))
                        $this->photo = $user->photo;
                }
                
                $this->change_date = date('Y-m-d H:m:i');
                $this->postal_code_letter = strtoupper($this->postal_code_letter);
               
                return true;
            }
            else
                return false;
        }
        
        protected function afterFind(){
            parent::afterFind();
            
        }
        
        protected function afterSave(){
            Yii::app()->user->setState('name', $this->name);
            Yii::app()->user->setState('photo', $this->photo);
            Yii::app()->user->setState('type', $this->type);
            parent::afterSave();
            
            //$this->password = null;
        }
        
        /**
        * Returns User model by its email
        * 
        * @param string $email 
        * @access public
        * @return User
        */
       public function findByEmail($email)
       {
         return self::model()->findByAttributes(array('email' => $email));
       }
       

       public static function getAdmin(){
           if(Yii::app()->user->getState('type') == 1){
               return true;
           }  else {
               return false;
           }
       }
	   
	   /**
		* get informatiomn abaut user destination
		* @param userId Users
		*/
		public static function userPlaceInfo($userId)
		{
			//user informatiomn
			$user = self::model()->findByPk($userId);
			
			/* user place info */
			$place = libPosts::model()->findByAttributes(array(
							'postal_code' => $user->postal_code
						));
						var_dump($place->attributes);die;
		}
}
