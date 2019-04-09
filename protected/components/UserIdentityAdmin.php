<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentityAdmin extends CUserIdentity {
    
    protected $_id;
    protected $_email;
    protected $_password;
    
    public function UserIdentityAdmin($email,$password){
        if(isset($email)){
            $this->_email = $email;
            $this->_password = $password;
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
        
        if(($user===null) || !CPasswordHelper::verifyPassword($this->_password, $user->password) || (isset($user) && $user->type != 1)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            
            $this->_id = $user->id;
            $this->_email = $user->email;
            $this->setState('name', $user->name);
            $this->setState('photo', $user->photo);
            $this->setState('type', $user->type);
            $this->errorCode = self::ERROR_NONE;
        }
       return !$this->errorCode;
    }
 
    public function getId(){
        return $this->_id;
    }
}