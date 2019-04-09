<?php
class HybridAuthIdentity extends CUserIdentity
{
    const VERSION = '2.2.2';
 
    /**
     * 
     * @var Hybrid_Auth
     */
    public $hybridAuth;
 
    /**
     * 
     * @var Hybrid_Provider_Adapter
     */
    public $adapter;
 
    /**
     * 
     * @var Hybrid_User_Profile
     */
    public $userProfile;
 
    public $allowedProviders = array('facebook');
 
    protected $config;
 
    function __construct() 
    {
        $path = Yii::getPathOfAlias('ext.HybridAuth');
        require_once $path . '/hybridauth-' . self::VERSION . '/hybridauth/Hybrid/Auth.php';  //path to the Auth php file within HybridAuth folder
 
        $this->config = array(
            "base_url" => "http://dropbord.nl/index.php/site/socialLogin?hauth.done=Facebook'", 
          //  "base_url" => Yii::app()->createUrl('site/socialLogin'), 
 
            "providers" => array(
                "Facebook" => array (
                   "enabled" => true,
                   "keys" => array ( 
                       "id" => "948819388477055", 
                       "secret" => "e492ca58985f3e62ad95ed5bba3e7f69",
                   ),
                   "scope" => "email"
                ),
            ),
 
            "debug_mode" => false, 
 
            // to enable logging, set 'debug_mode' to true, then provide here a path of a writable file 
            "debug_file" => "",             
        );
 
        $this->hybridAuth = new Hybrid_Auth($this->config);
    }
 
    /**
     *
     * @param string $provider
     * @return bool 
     */
    public function validateProviderName($provider)
    {
        if (!is_string($provider))
            return false;
        if (!in_array($provider, $this->allowedProviders))
            return false;
 
        return true;
    }
    
    public function login()
    {
        $this->email = $this->userProfile->email;  //CUserIdentity
        Yii::app()->user->login($this, 0);
    }
 
    public function authenticate() 
    {
        return true;
    }
 
}