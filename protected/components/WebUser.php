<?php
/*
 * Get role from db Users table type field
 */
class WebUser extends CWebUser {
    private $_model = null;
    const admin = 1,
          user = 0;
    public $name;


    function getRole() {
        if($user = $this->getModel()){
//            if($user->type == self::admin)
//                $this->name = 'administrator';
//            elseif ($user->type == self::user) 
//                $this->name = 'user';
//            else
//                $this->name = 'guest';
            
            return $user->type;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id, array('select' => 'type'));
        }
        return $this->_model;
    }
}