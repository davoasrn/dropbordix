<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity {
    
    protected $_id;
    protected $_facebook_id;
    protected $_email;
    protected $_password;
    
    public function userIdentity($email=null,$password = null, $facebook=null){
        if(isset($email)){
            $this->_email = $email;
            $this->_password = $password;
        }elseif (isset($facebook)) {
            $this->_facebook_id = $facebook;
        }else{
            return $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
    }


    /**
    * Authenticates a user.
    * In practical applications, this should be changed to authenticate
    * against some persistent user identity storage (e.g. database).
    * @return boolean whether authentication succeeds.
    */
    
    public function authenticate(){
        // Get user data
        if(isset($this->_email))
            $user = Users::model()->find('LOWER(email)=?', array(strtolower($this->_email)));
        elseif (isset($this->_facebook_id)) {
            $user = Users::model()->findByAttributes(array('facebook_id'=>$this->_facebook_id));
        }
        
        if(($user===null) || !CPasswordHelper::verifyPassword($this->_password, $user->password) && $user->type != 3) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            
            $this->_id = $user->id;
            $this->_email = $user->email;
            $this->setState('name', $user->name);
            $this->setState('photo', $user->photo);
            $this->setState('type', $user->type);
            $this->errorCode = self::ERROR_NONE;
			
			/*
			* User place
			*/
			
			if(!empty($user->latitude) && !empty($user->longitude)){
				$sql = 'SELECT id, country_code, postal_code, state, place_name, ( 6371 * acos( cos( radians(:latitude ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( :longitude ) ) + sin( radians( :latitude ) ) * sin( radians( latitude ) ) ) ) AS distance
						FROM lib_posts
						HAVING distance <50
						ORDER BY distance
						LIMIT 1'; 
		
				$connection=Yii::app()->db;
				$results=$connection->createCommand($sql)								
						->bindValues(array(
							':latitude' => $user->latitude,
							':longitude' => $user->longitude
						))
						->queryRow();
				if(!empty($results)){
					$this->setState('placeName', $results['state'].', '.$results['place_name']);
					$this->setState('post', $results['country_code'].' '.$results['postal_code'] );
				}				
			}
        }
       return !$this->errorCode;
    }
 
    public function getId(){
        return $this->_id;
    }
}