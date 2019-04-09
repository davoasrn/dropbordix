<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
        'theme'=>'basic',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'ext.uploadify.*',
            'ext.SmartClientScript.SmartClientScript',
                //for facebook login
                'ext.eoauth.*',
                'ext.eoauth.lib.*',
                'ext.lightopenid.*',
                'ext.eauth.*',
                'ext.eauth.services.*',
                'application.helpers.*',
                'bootstrap.helpers.*',
                'bootstrap.widgets.*',
                'bootstrap.behaviors.*',
                'bootstrap.components.*',
                //'bootstrap.helpers.TbArray',
                
	),
        'aliases' => array(
            //If you used composer your path should be
            'xupload' => 'ext.vendor.asgaroth.xupload',
            //If you manually installed it
            'xupload' => 'ext.xupload',
            'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
        ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin',
                'content',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','*'),
                        'generatorPaths' => array('bootstrap.gii'),
		),
	),
    
        'language' => 'nl',

	// application components
	'components'=>array(
            'clientScript' => array(
    'class'=>'ext.SmartClientScript.SmartClientScript',
),
            'cache'=>array( 
    'class'=>'system.caching.CFileCache'
),
                'clientScript' => array('scriptMap' => array('jquery.js' => false, )),
                'loid' => array(
                    'class' => 'ext.lightopenid.loid',
                ),
                'bootstrap' => array(
                    'class' => 'bootstrap.components.TbApi',   
                ),
                'image'=>array(
                  'class'=>'application.extensions.image.CImageComponent',
                    // GD or ImageMagick
                    'driver'=>'GD',
                    // ImageMagick setup path
                    'params'=>array('directory'=>'/opt/local/bin'),
                ),
                'eauth' => array(
                    'class' => 'ext.eauth.EAuth',
                    'popup' => true, // Use the popup window instead of redirecting.
                    'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache'.
                    'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
                    'services' => array( // You can change the providers and their classes.
                        'facebook' => array(
                            // register your app here: https://developers.facebook.com/apps/
                            'class' => 'FacebookOAuthService',
                            'client_id' => '948819388477055',
                            'client_secret' => 'e492ca58985f3e62ad95ed5bba3e7f69',
                        ),
                    ),
                ),

                'mailer' => array(
                    'class' => 'application.extensions.mailer.EMailer',
                    'pathViews' => 'webroot.themes.basic.email',
                    'pathLayouts' => 'webroot.themes.basic.layouts'
                 ),
                'user'=>array(
                        // enable cookie-based authentication
                        'allowAutoLogin'=>true,
                        'class' => 'WebUser'
                ),
                'authManager' => array(
                    'class' => 'PhpAuthManager',
                    'defaultRoles' => array('guset')
                ),
                'Smtpmail'=>array(
                    'class'=>'application.extensions.smtpmail.PHPMailer',
                    'Host'=>"mail.yourdomain.com",
                    'Username'=>'test@yourdomain.com',
                    'Password'=>'test',
                    'Mailer'=>'smtp',
                    'Port'=>26,
                    'SMTPAuth'=>true, 
                    'useFileTransport'=>false,
                ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dropbord_main',
			'emulatePrepare' => true,
			'username' => 'dropbord_main',
			'password' => 'hayastan2007',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'arakelov.ando@gmail.com',
                'webRoot' => dir(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'),
                'uploadPath'=>dirname(__FILE__).'/../../images/',
                'uploadUrl'=>'/images/',
                'siteUrl' => 'http://dropbord.nl',
                'payment' => array(
                    'merchant_id' => '220335347510001',
                    'security_key' => '220335347510001',
                    'security_key_version' => '1',
                    'test_mode' => true,
                    'orderId' => 'dropbord-' . time(),
                    'videoPrice' => 15,
                    'paymentMethod' =>array()
                )
	),
        
);