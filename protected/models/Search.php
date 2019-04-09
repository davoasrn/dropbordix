<?php

class Search extends CFormModel 
{

    public $email;
    public $trefwoord1;
    public $trefwoord2;
    public $trefwoord3; 
    public $trefwoord4;
    public $zipcode; 
    public $range;       

    public function rules() {
              return array(
             array('email,trefwoord1,trefwoord2,trefwoord3,trefwoord4,zipcode,range', 'safe'),
             array('email', 'required','on'=>"searchMe"),
             array('email','email','message' =>'E-mail komt niet overeen formaat'),
            );

            return $rules;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
            return array(
                    'email'=>'email',
                    'zipcode'=>'zipcode',
                    'range'=>'range',
            );
    }

}