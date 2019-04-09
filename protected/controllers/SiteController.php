<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
     
  	/*public function accessRules()
	{
		return array(
		array('deny',  // deny all users
				'users'=>array('contact')
			),
//			
		);
	}*/
	public function actions()
	{
	   
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
                        'upload'=>array(
                            'class'=>'xupload.actions.XUploadAction',
                            'path' =>Yii::app() -> getBasePath() . "/../uploads",
                            'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
                        ),
                        'oauth' => array(
                            // the list of additional properties of this action is below
                            'class'=>'ext.hoauth.HOAuthAction',
                            // Yii alias for your user's model, or simply class name, when it already on yii's import path
                            // default value of this property is: User
                            'model' => 'Users', 
                            // map model attributes to attributes of user's social profile
                            // model attribute => profile attribute
                            // the list of avaible attributes is below
                            'attributes' => array(
                              'email' => 'email',
                              'name' => 'displayName',
                              'photo' => 'photoURL',
                              'phone' => 'phone',
                              'postal_code' => 'zip',
                              'password' => 'identifier',
                              'repeat_password' => 'identifier',
                              //'lname' => 'lastName',
                              //'gender' => 'genderShort',
                              //'birthday' => 'birthDate',
                              // you can also specify additional values, 
                              // that will be applied to your model (eg. account activation status)
                             // 'acc_status' => 1,
                            ),
                          ),
                          // this is an admin action that will help you to configure HybridAuth 
                            // (you must delete this action, when you'll be ready with configuration, or 
                            // specify rules for admin role. User shouldn't have access to this action!)
                            'oauthadmin' => array(
                              'class'=>'ext.hoauth.HOAuthAdminAction',
                            ),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
                $login = new LoginForm;
                //$widgetsData = array();
                if(!is_null(Yii::app()->user->getId())){
                    $userId = Yii::app()->user->getId();
                    $noWidgets = Yii::app()
                           ->db->createCommand(
                                   'select id,name 
                                    from lib_widgets l
                                    where id not in (
                                        select widget_id 
                                        from user_widgets
                                        where user_id = :user_id
                                    )'
                                   )
                           ->bindValues(array(':user_id'=> $userId))
                           ->queryAll();
                    foreach ($noWidgets as $noWidget){
                           switch ($noWidget['id']){
                                case LibWidgets::TOP:
                                   $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                                //"condition" => "1 = 1",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                                    if(!empty($dataTop))
                                       $widgetsData[LibWidgets::TOP] = $dataTop;
                               
                                case LibWidgets::AUTO:
                                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR)
                                                        )
                                                );
                                    if(!empty($dataAuto))
                                        $widgetsData[LibWidgets::AUTO] = $dataAuto;

                                case LibWidgets::MY_SEARCH://stex Davoin asem irany dni
                                    $dataMySearch =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "category_id = ".LibCategory::CAR,
                                                                     "order" => "view_count desc",
                                                                     "limit" => 4,
                                                                     "together" => true
                                                             )
                                                     );
													   /*
                            *
                            *check the condition for search me
                            *
                            */
                            
                          /*  $userCriteria=new CDbCriteria();
                            $userCriteria->join='inner join users u on `t`.email=u.email';
                            $userCriteria->condition='u.id='.$userId;
                            $userSearchMe=SearchMe::model()->findAll($userCriteria);
                            foreach(Announcement::model()->findAll() as $announcement)
                            {
                               
                            foreach($userSearchMe as $param)
                            {
                                
                                $query = new CDbCriteria;
                                    //$query->select = 'lbt.* ';
                                    $query->join = ' LEFT JOIN `auto_detail` AS `ad` ON t.id = ad.announcement_id';
                                    $query->join.= " LEFT JOIN `users` AS `u` ON u.id = t.user_id ";
                                    $query->join.= " LEFT JOIN `lib_fuel_types` AS `lbt` ON lbt.id = ad.fuel_id ";

                                            
                                            
                                            
                                    if(!empty($param["trefwoord1"]))
                                    {

                                        $condition=" t.id =".$announcement["id"]." and ( t.name like '".$param["trefwoord1"]."%' or t.description like '".$param["trefwoord1"]."%' )";


                                    }

                                        
                                    if(!empty($param["trefwoord2"]))
                                    {
                                        $condition+=" and  ( t.name like '".$param["trefwoord2"]."%' or t.description like '".$param["trefwoord2"]."%')";
                                    }
                                    if(!empty($param["trefwoord3"]))
                                    {
                                        $condition+=" and  ( t.name like '".$param["trefwoord3"]."%' or ad.year like '".$param["trefwoord3"]."%' or t.description like '".$param["trefwoord3"]."%')";
                                    }
                                    if(!empty($param["trefwoord4"]))
                                    {
                                        $condition+=" and  ( t.name like '".$param["trefwoord4"]."%' or  lbt.name like '".$param["trefwoord4"]."%' or t.description like '".$param["trefwoord4"]."%')";
                                    }
                                    
                                    $query->condition=$condition;
                                    
                                    $data['results']=Announcement::model()->findAll($query);
                                        
                                    if(!empty($param["zipcode"]) && !empty($param["latitude"]) && !empty($param["longitude"]))
                                    {
                                         $range=$param["range"];
                                        $zipcode2 = urlencode($param["zipcode"]);
                                            $address = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$zipcode2.'&sensor=false');
                                            $address = json_decode($address);

                                            if($address->status == 'OK')
                                            {
                                                $data['lat'] = $address->results[0]->geometry->location->lat;
                                                $data['lng'] = $address->results[0]->geometry->location->lng;



                                                            $lnglat = array(
                                                   'lat'  	=> 	 $data['lat'],
                                                   'lng'	=>	 $data['lng'],
                                               );

                                                            //$this->session->set_userdata($lnglat);


                                                            $data['limit']    =   $range;
                                                $limit = $data['limit'];

                                                $resultnum = 0;

                                               foreach($data['results'] as $result){

                                                    $lat1 = $result["user"]["latitude"];
                                                    $lng1 = $result["user"]["longitude"];
                                                    $lat2 = $data['lat'];
                                                    $lng2 = $data['lng'];

                                                    $pi80 = M_PI / 180;
                                                    $lat1 *= $pi80;
                                                    $lng1 *= $pi80;
                                                    $lat2 *= $pi80;
                                                    $lng2 *= $pi80;

                                                    $r = 6372.797; // mean radius of Earth in km
                                                    $dlat = $lat2 - $lat1;
                                                    $dlng = $lng2 - $lng1;
                                                    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
                                                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                                    $km = $r * $c;

                                                    if($km > $data['limit']){
                                                        unset($data['results'][$resultnum]);
                                                    }else{

                                                    }
                                                    $resultnum ++;

                                                }
                                             }
                                              else {				
                                                            die('post_code_error');
                                            }
                                    }
                                    


                                }
                            }
                        
                                    if(!empty($data['results'])) //$dataMySearch
                                        $widgetsData[LibWidgets::MY_SEARCH] = $data['results'];*///$dataMySearch
                                    if(!empty($dataMySearch))
                                        $widgetsData[LibWidgets::MY_SEARCH] = $dataMySearch;
                                case LibWidgets::MY:
                                    $dataMy =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "1 = 1 and user_id = :user_id",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                     "params" => array(':user_id' => $userId)
                                                             )
                                                     );
                                    if(!empty($dataMy))
                                        $widgetsData[LibWidgets::MY] = $dataMy;
                                case LibWidgets::SAVED:
                                    $dataSaved =  Announcement::model()
                                                    ->with(array(
                                                        'savedAnn'=>array(
                                                            'select'=>false,
                                                            'joinType'=>'INNER JOIN',
                                                        )
                                                    ))
                                                    ->findAll(
                                                             array(
                                                                    "condition" => "`savedAnn`.user_id = :user_id and status != :status",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                    "params" => array(':user_id' => $userId, ':status' => LibAnnouncementStatus::not_verfied)
                                                             )
                                                     );
                                                 
                               if(!empty($dataSaved))
                                   $widgetsData[LibWidgets::SAVED] = $dataSaved;
                            }
                   }
                }else{
                    $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "status != :status",
																"params" => array(':status' => LibAnnouncementStatus::not_verfied),
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                    
                    if(!empty($dataTop))
                                   $widgetsData['1'] = $dataTop;
                    
                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id and status != :status",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR, ':status' => LibAnnouncementStatus::not_verfied)
                                                        )
                                                );
                    if(!empty($dataAuto))
                                   $widgetsData['2'] = $dataAuto;
                }
                $categories = CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => 0)),'id','name');
		$this->render('index',array(
                        'login' => $login,
                        'widgetsData' => $widgetsData,
                       // 'topAnnouncements' => $topAnnouncements,
                        //'myAnnouncements' => $myAnnouncements,
                        'categories' => $categories
                            )
                        );
	}
        
	/**
	 * This is category
	 * when an action is not explicitly requested by users.
	 */
	public function actionCategoryesList()
	{
                $login = new LoginForm;
                $categories = CHtml::listData(LibCategory::model()->findAll(),'id','name');
		$this->render('categoryesList',array(
                        'categories' => $categories,
                        'login' => $login,
                            )
                        );
	}
	
	/**
	* function get announcements result
	* @param int id type of page
	* @param int is_widget 0-category, 1- widget
	* @param int pages count of last showing pages
	*/
	public function resultAnnouncement($id,$is_widget,$page = 1){
		$limit = 20;
		if($page == 1){
			$offset = 0;
		}else{
			$offset = $page * $limit - $limit;
		}
		
		if($is_widget == 0){
			$libCat = trim($id.','.LibCategory::getChildrenString($id),',');
			$criteria = new CDbCriteria;
			$criteria->addInCondition('category_id',array($libCat));
			//$criteria->AddCondition('status'!=LibAnnouncementStatus::not_verfied);
			$criteria->limit = $limit;
			$criteria->offset = $offset;
			//$criteria->pagination =false;
			$criteria->order = 'view_count desc';
			$announcements = Announcement::model()->findAll($criteria);
			$category = LibCategory::model()->findByPk($id);
			$name = $category->name;
		}elseif($is_widget == 1 ){
			$widget = LibWidgets::model()->findByPk($id);
			$name = $widget->name;
			if ($id == LibWidgets::AUTO) {
					   $dataAuto =  Announcement::model()->findAll(
												array(
														"condition" => "category_id = :category_id and status != :status",
														"order" => "view_count desc",
														"together" => true,
														"params" => array(':category_id' => LibCategory::CAR, ':status' => LibAnnouncementStatus::not_verfied),
														"limit" => $limit,
														"offset" =>$offset
												)
										);
					   if(!empty($dataAuto))
						   $announcements = $dataAuto;
			}elseif ($id == LibWidgets::MY_SEARCH && !is_null(Yii::app()->user->getId())) {//Davoin asem ani
				$dataMySearch =  Announcement::model()->findAll(
												array(
														"condition" => "category_id = ".LibCategory::CAR,
														"order" => "view_count desc",
														"together" => true,
														"limit" => $limit,
														"offset" =>$offset
												)
										);
				if(!empty($dataMySearch))
					$announcements = $dataMySearch;
					   
			}elseif ($id == LibWidgets::MY && !is_null(Yii::app()->user->getId())) {
				$dataMy =  Announcement::model()->findAll(
												array(
														"condition" => "status != :status and user_id = :user_id",
														"order" => "rand()",
														"together" => true,
														"params" => array(':user_id' => Yii::app()->user->getId(), ':status' => LibAnnouncementStatus::not_verfied),
														"limit" => $limit,
														"offset" =>$offset
												)
										);
					   if(!empty($dataMy))
						   $announcements = $dataMy;
			}elseif ($id == LibWidgets::SAVED && !is_null(Yii::app()->user->getId())) {
				$dataSaved =  Announcement::model()
											->with(array(
												'savedAnn'=>array(
													'select'=>false,
													'joinType'=>'INNER JOIN',
												)
											))
											->findAll(
													 array(
															"condition" => "`savedAnn`.user_id = :user_id and status != :status",
															 "order" => "rand()",
															 "together" => true,
															"params" => array(':user_id' => Yii::app()->user->getId(), ':status' => LibAnnouncementStatus::not_verfied),
															"limit" => $limit,
															"offset" =>$offset
													 )
											 );
					   if(!empty($dataSaved))
						   $announcements = $dataSaved;
			}else{
				$dataTop =  Announcement::model()->findAll(
												array(
														"condition" => "status != :status",
														"params" => array(':status' => LibAnnouncementStatus::not_verfied),
														"order" => "view_count desc",
														//"together" => true,
														"limit" => $limit,
														"offset" =>$offset
												)
										);
					   if(!empty($dataTop))
						   $announcements = $dataTop;
					   
					   $name = 'Top advertenties';
			}
			
			
		}
		
		if(!isset($announcements)){
			$announcements = null;
		}
		return array($announcements, $name, $page);
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionList($id, $is_widget)
	{
            $login = new LoginForm;
			list($announcements, $name, $page) = $this->resultAnnouncement($id, $is_widget);
     
			$this->render('list',array(
				'login' => $login,
				'announcements' => $announcements,
				'name' => $name,
				'type_id' => $id,
				'is_widget' => $is_widget,
				'page' => $page,
				));
	}
	
	/**
	* function return result after clicking load more button in page
	*/
	public function actionLoadMore($id, $is_widget){
		$this->layout = false;
		if(isset($_POST['id']) && !empty($_POST['id'])){
				list($announcements, $name, $page) = $this->resultAnnouncement($id, $is_widget,$_POST['id']);
				if(!isset($announcements)){
						$announcements = null;
				}
				
				if(isset($announcements) && !empty($announcements)){
					foreach ($announcements as $announcement){ 
						$this->renderPartial('//announcement/_info',array('announcement' => $announcement, 'page' => $page));        
					}
				}
		}
		
		
		/*$this->render('loadMore',array(
				'announcements' => $announcements,
				));*/
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
            	public function actionContact()
            	{
            	  
            		$model=new Contact;
            	    //$model->scenario = "contact";
                    $this->performAjaxValidation($model);
            		if(isset($_POST['Contact']))
            		{   
            	             
            			$model->attributes=$_POST['Contact'];
                                    $validUser=$model->validate();
            			if($validUser)
            			{
            			 
                                        if($model->save()){
            
											  $ToEmail ='gtugam@gmail.com'; //Yii::app()->Smtpmail;
											  $EmailSubject = 'vragen of opmerkingen'; 
											  $mailheader = "From: ".$model->email."\r\n"; 
											  //$mailheader .= "Reply-To:  \r\n"; 
											  $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
											  $MESSAGE_BODY = "Telefoonnummer : ".$model->phone."\r\n"; 
											  $MESSAGE_BODY .= "Comment: ".nl2br($model->comments).""; 
											  mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader);
            
											if(!Yii::app()->request->isAjaxRequest)
																	$this->redirect(array('index'));
											else {
																	echo CJSON::encode(array(
																			'status'=>'saved'
													));
													Yii::app()->end();
											}
                                      }
            			
            			}
            		}
                    $this->renderPartial('contact',array(
            			'model'=>$model
            		),false,true); //Yii::app()->request->isAjaxRequest
                    	
            	
            	   }
               public function actionValidContact()
               {
                   	
                	 $model=new Contact;
                         $model->scenario='contact';
                         
                     if(isset($_POST['Contact']))
                    {

                     $model->attributes=$_POST['Contact'];
                     $valid=$model->validate(); 

                    }
                       
                    $error = CActiveForm::validate($model);
                    
                    if($error!='[]')
                        echo $error;
                    else {
                        echo CJSON::encode(array(
                            'status'=>'success'
                        ));
                    }
                    Yii::app()->end();
              	}
    
            public function actionUseContact()
            	{
                    $model=new Contact;
                    $this->performAjaxValidation($model);
                    if(isset($_POST['Contact']))
                    {
                            $useContact=$model->attributes=$_POST['Contact'];
                            $validUser=$model->validate();
                            if($validUser)
                            {

                                $Criteria = new CDbCriteria();
                                $Criteria->condition = "`user`.`email` = '".$useContact['email']."'" ;
                                $Criteria->order = "t.id ASC";
                                $Criteria->select = "t.id";

                                $data['results'] = Announcement::model()->with('user')->findAll($Criteria);
                                if(!empty($data['results']))
                                {
                                    $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                                    $mailer->From = $sendModel->email;
                                    $mailer->AddReplyTo($model->user->email);
                                    $mailer->AddAddress($model->user->email);
                                    $mailer->FromName = $sendModel->email;
                                    $mailer->CharSet = 'UTF-8';
                                    $mailer->Subject = Yii::t('dropbord.nl', $model->name);
                                    $mailer->MsgHTML($this->render('//email/emailAboutAnnouncementTo', array(
                                                            'model'=> $model,
                                                            'sendModel' => $sendModel
                                                        )
                                                        , true
                                                       ));
                                    if($mailer->Send())
                                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Uw e-mail succesvol verzonden");
                                    
                                    
                                    
                                    $MESSAGE_BODY=" ";
                                    foreach($data['results'] as $result)
                                    {
                                        $MESSAGE_BODY.= nl2br(CHtml::link('show announcement',Yii::app()->params['siteUrl'].Yii::app()->createUrl('site/show',array('id' =>$result["id"])))." \r\n"); 
                                    }
                                    $ToEmail ='gtugam@gmail.com'; //Yii::app()->Smtpmail;
                                    $EmailSubject = 'vragen of opmerkingen'; 
                                    $mailheader = "From: ".$useContact['email']."\r\n"; 
                                    $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
                                    mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader);
                                    
                                    if(!Yii::app()->request->isAjaxRequest)
                                                            $this->redirect(array('index'));
                                    else {
                                            echo CJSON::encode(array(
                                                    'status'=>'saved'
                                            ));
                                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Uw aankondiging succesvol opgeslagen");
                                        Yii::app()->end();
                                        }
                                }
                                else
                                {
                                     if(!Yii::app()->request->isAjaxRequest)
                                                            $this->redirect(array('index'));
                                    else {
                                                            echo CJSON::encode(array(
                                                                    'status'=>'isnull'
                                            ));
                                        Yii::app()->end();
                                        }

                                }


                                    }
                            }
            	
                    $this->renderPartial('contact',array(
            			'model'=>$model
            		),false, true);
            	}
                 public function actionValidUseContact()
                   {
                       	
                    	     $model=new Contact;
                             $model->scenario='contact';
                             
                         if(isset($_POST['Contact']))
                            {
                                
                             $model->attributes=$_POST['Contact'];
                             $valid=$model->validate(); 
                                        
                            }
                           
                        $error = CActiveForm::validate($model);
                        
                        if($error!='[]')
                            echo $error;
                        else {
                            echo CJSON::encode(array(
                                'status'=>'success'
                            ));
                        }
                        Yii::app()->end();
                  	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
                if(!Yii::app()->request->isAjaxRequest){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                    $this->redirect (Yii::app()->homeUrl);
                }
		$model=new LoginForm;
                $register = new Users;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
                        
			// validate user input and redirect to the previous page if valid
                        $error = CActiveForm::validate($model);
                        
                        if($error!='[]')
                            echo $error;
                        else {
                            $model->login();
                            echo CJSON::encode(array(
                                'status'=>'success'
                            ));
                        }
                        Yii::app()->end();
			if($model->validate() && $model->login()){
                                if(Yii::app()->request->isAjaxRequest){
                                    echo CJSON::encode(array(
                                            'status'=>'success'
                                       ));
                                      Yii::app()->end();
                                }else{
                                    $this->redirect(Yii::app()->user->returnUrl);
                                }
                        }elseif(Yii::app()->request->isAjaxRequest){
                            echo CActiveForm::validate($model);
                            Yii::app()->end();
                            echo CJSON::encode(array(
                                        'status'=>'fail'
                                   ));
                                  Yii::app()->end();
                        }
		}
		// display the login form
		$this->renderPartial('login',array('model'=>$model,'register' => $register), false, true);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    
    public function actionSearch()
	{
		
        $keyword    =   $_POST['keyword'];
        $zipcode    =   $_POST['zipcode'];
        $category   =   $_POST['category'];
        
        $range=$_POST['range'];
        
        $now=date('Y-m-d');
           
                $criteria = new CDbCriteria();
                 
               // $criteria->with = array('user');
                    //$criteria->compare('t.end_date', $now, true);     
             
                     if(!empty($keyword) or $keyword != 'Zoeken op trefwoord'){
                 
                       $criteria->compare('t.name', $keyword, true);
                      }
                       if(!empty($category)){
                 
                       $criteria->compare('t.category_id', $category, true);
                      }
                     
            $data['results'] = Announcement::model()->with('user')->findAll($criteria);
            
        if($zipcode == NULL){
            $data['lat'] = '';
            $data['lng'] = '';
            $data['limit']    =   '';
        }else if($zipcode == '1234 XX'){
            $data['lat'] = '';
            $data['lng'] = '';
            $data['limit']    =   '';
        }
        else
        {
            $zipcode2 = urlencode($zipcode);
            $address = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$zipcode2.'&sensor=false');
            $address = json_decode($address);

            if($address->status == 'OK')
            {
                $data['lat'] = $address->results[0]->geometry->location->lat;
                $data['lng'] = $address->results[0]->geometry->location->lng;
				
				
		
				$lnglat = array(
                   'lat'  	=> 	 $data['lat'],
                   'lng'	=>	 $data['lng'],
               );

				//$this->session->set_userdata($lnglat);
								
                
				$data['limit']    =   $range;
                $limit = $data['limit'];

                $resultnum = 0;

               foreach($data['results'] as $result){

                    $lat1 = $result["user"]["latitude"];
                    $lng1 = $result["user"]["longitude"];
                    $lat2 = $data['lat'];
                    $lng2 = $data['lng'];
                     
                    $pi80 = M_PI / 180;
                    $lat1 *= $pi80;
                    $lng1 *= $pi80;
                    $lat2 *= $pi80;
                    $lng2 *= $pi80;

                    $r = 6372.797; // mean radius of Earth in km
                    $dlat = $lat2 - $lat1;
                    $dlng = $lng2 - $lng1;
                    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                    $km = $r * $c;
                    
                    if($km > $data['limit']){
                        unset($data['results'][$resultnum]);
                    }else{

                    }
                    $resultnum ++;

                }
             }
              else {				
				die('post_code_error');
            }
           }
           
           echo $this->renderPartial('search',array('model'=>$data['results'], 'keyword' => $keyword), false, true);
           Yii::app()->end();
           
	}
    public function actionSuggest()
    {
        $string = '';
        $name=$_REQUEST['queryString'];
        $q = new CDbCriteria;
        $q->condition="t.name like '".$name."%'";
            
            $model=Announcement::model()->findAll($q);
            $string.= '<ul>';
            foreach($model as $result)
            {
                //var_dump($result->id,$result->name);die;
                $string.= '<li onClick="fillId(\''.addslashes($result->id).'\');fill(\''.addslashes($result->name).'\');">'.$result->name.'</li>';
            }
            $string.= '</ul>';
            echo $string;
       // var_dump($_REQUEST['queryString'],"aaaaa",$model);die;
    }
        	public function actionSearchMe()
        	{
        	     $users=new Users;
                 $announcement=new Announcement;
                 $auto_detail=new AutoDetail;
        		
                $this->renderPartial('searchMe',array(
                'users'=>$users,
                'announcement'=>$announcement,
                'auto_detail'=>$auto_detail,
                
                ),false, false);
                //$this->render('searchMe');
        	}
        protected function performAjaxValidation($model)
        {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'father-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
        
//        //action only for the login from third-party authentication providers, such as Google, Facebook etc. Not for direct login using username/password
//        public function actionLoginFb()
//        {
//            if (!isset($_GET['provider']))
//            {
//                $this->redirect(array('/site/index'));
//                return;
//            }
//
//            try
//            {
//                //Yii::import('ext.components.HybridAuthIdentity');
//                $haComp = new HybridAuthIdentity();
//                
//                if (!$haComp->validateProviderName($_GET['provider']))
//                    throw new CHttpException ('500', 'Invalid Action. Please try again.');
//
//                $haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);
//                
//                $haComp->userProfile = $haComp->adapter->getUserProfile();
//                $haComp->login();  //further action based on successful login or re-direct user to the required url
//            }
//            catch (Exception $e)
//            {
//                //process error message as required or as mentioned in the HybridAuth 'Simple Sign-in script' documentation
//                $this->redirect(array('/site/index'));
//                return;
//            }
//            $haComp->adapter = $haComp->hybridAuth->authenticate($_GET['provider']);
//            $haComp->userProfile = $haComp->adapter->getUserProfile();
// 
//            $haComp->login();
//            $this->redirect('index');  //redirect to the user logged in section..
//        }
//        
//        
//        public function actionSocialLogin()
//        {
//            Yii::import('application.components.HybridAuthIdentity');
//            $path = Yii::getPathOfAlias('ext.HybridAuth');
//            require_once $path . '/hybridauth-' . HybridAuthIdentity::VERSION . '/hybridauth/index.php';
//
//        }
        
        public function actionLoginSocial() {
            $serviceName = Yii::app()->request->getQuery('service');
            if (isset($serviceName)) {
                /** @var $eauth EAuthServiceBase */
                $eauth = Yii::app()->eauth->getIdentity($serviceName);
                $eauth->redirectUrl = Yii::app()->user->returnUrl;
                $eauth->cancelUrl = $this->createAbsoluteUrl('site/index');

                try {
                    if ($eauth->authenticate()) {

                        $identity = new EAuthUserIdentity($eauth);
                        $attributes = $eauth->getAttributes();
                        // successful authentication
                        if ($identity->authenticate()) {
                            $model = Users::model()->findByAttributes(array('facebook_id' => $attributes['id']));
                            if(!isset($model)){ 
                                $model = new Users;
                                if(isset($attributes['email']))
                                $model->email = $attributes['email'];
                                $model->facebook_id = $attributes['id'];
                                $model->name = $attributes['name'];
                                $model->photo = $attributes['picture'];
                                $model->type = 3;
                                if($model->save()){

                                    if(isset($attributes['picture']) && !empty($attributes['picture'])){
                                        $folder=Yii::getPathOfAlias('webroot.images').DIRECTORY_SEPARATOR;// folder for uploaded files
                                        if(!is_dir($folder.$model->id)){
                                                mkdir($folder.$model->id);
                                        }
                                       // if(copy($attributes['picture'], Yii::app()->basePath.'/../images/'.$model->id."/".$file['name']));
                                    }

                                }
                            }
                            $identityU=new UserIdentity($model->email,null,$model->facebook_id);
                            $identityU->authenticate();
                            Yii::app()->user->login($identityU,0);

                           // Yii::app()->user->login($identity);
    //save anem bazajum ete chka

                            // special redirect with closing popup window
                            $eauth->redirect();
                        }
                        else {
                            // close popup window and redirect to cancelUrl
                            $eauth->cancel();
                        }
                    }

                    // Something went wrong, redirect to login page
                    $this->redirect(array('site/index'));
                }
                catch (EAuthException $e) {
                    // save authentication error to session
                    Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                    // close popup window and redirect to cancelUrl
                    $eauth->redirect($eauth->getCancelUrl());
                }
            }

        // default authorization code through login/password ..
    }
    
     /*
     * function for getting information from sent email and open it in modal windov
     * @param $id Announcement id
     */
    public function actionShow($id){
        $model = Announcement::model()->findByPk($id);
        if(isset($model)){
            $cs = Yii::app()->clientScript;
            $cs->registerScript('showFromEmail', 'js:navigationToView("'.Yii::app()->createUrl('announcement/view',array('id' =>$model->id)).'")', CClientScript::POS_READY);
//            $cs->registerScript('showFromEmail', 'js:navigation("'.Yii::app()->createUrl('announcement/view',array('id' =>$model->id)).'")', CClientScript::POS_READY);
        }
        $login = new LoginForm;
        if(!is_null(Yii::app()->user->getId())){
                    $userId = Yii::app()->user->getId();
                    $noWidgets = Yii::app()
                           ->db->createCommand(
                                   'select id,name 
                                    from lib_widgets l
                                    where id not in (
                                        select widget_id 
                                        from user_widgets
                                        where user_id = :user_id
                                    )'
                                   )
                           ->bindValues(array(':user_id'=> $userId))
                           ->queryAll();
                    foreach ($noWidgets as $noWidget){
                           switch ($noWidget['id']){
                                case LibWidgets::TOP:
                                   $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "status != :status",
																"params" => array(':status' => LibAnnouncementStatus::not_verfied),
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                                    if(!empty($dataTop))
                                       $widgetsData[LibWidgets::TOP] = $dataTop;
                               
                                case LibWidgets::AUTO:
                                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id and status != :status",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR, ':status' => LibAnnouncementStatus::not_verfied)
                                                        )
                                                );
                                    if(!empty($dataAuto))
                                        $widgetsData[LibWidgets::AUTO] = $dataAuto;

                                case LibWidgets::MY_SEARCH://stex Davoin asem irany dni
                                    $dataMySearch =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "category_id = ".LibCategory::CAR,
                                                                     "order" => "view_count desc",
                                                                     "limit" => 4,
                                                                     "together" => true
                                                             )
                                                     );
                                    if(!empty($dataMySearch))
                                        $widgetsData[LibWidgets::MY_SEARCH] = $dataMySearch;
                                case LibWidgets::MY:
                                    $dataMy =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "user_id = :user_id and status != :status",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                     "params" => array(':user_id' => $userId, ':status' => LibAnnouncementStatus::not_verfied)
                                                             )
                                                     );
                                    if(!empty($dataMy))
                                        $widgetsData[LibWidgets::MY] = $dataMy;
                                case LibWidgets::SAVED:
                                    $dataSaved =  Announcement::model()
                                                    ->with(array(
                                                        'savedAnn'=>array(
                                                            'select'=>false,
                                                            'joinType'=>'INNER JOIN',
                                                        )
                                                    ))
                                                    ->findAll(
                                                             array(
                                                                    "condition" => "`savedAnn`.user_id = :user_id and status != :status",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                    "params" => array(':user_id' => $userId,':status' => LibAnnouncementStatus::not_verfied)
                                                             )
                                                     );
                                                 
                               if(!empty($dataSaved))
                                   $widgetsData[LibWidgets::SAVED] = $dataSaved;
                            }
                   }
                }else{
                    $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "status != :status",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                    
                    if(!empty($dataTop))
                                   $widgetsData['1'] = $dataTop;
                    
                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id and status != :status",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR, ':status' => LibAnnouncementStatus::not_verfied)
                                                        )
                                                );
                    if(!empty($dataAuto))
                                   $widgetsData['2'] = $dataAuto;
                }
        $categories = CHtml::listData(LibCategory::model()->findAll(),'id','name');
        $this->render('index',array(
                'login' => $login,
                'widgetsData' => $widgetsData,
               // 'topAnnouncements' => $topAnnouncements,
                //'myAnnouncements' => $myAnnouncements,
                'categories' => $categories
                    )
                );
    }
    
    public function actionUserAnnouncements($id){
        $user = Users::model()->findByPk($id);
        if(!isset($user)){
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Gebruiker bestaat niet");
            $this->redirect (Yii::app()->homeUrl);
        }
        $login = new LoginForm;
        $announcements = Announcement::model()->findAllByAttributes(array('user_id' => $user->id));
        $name = $user->name;
        $this->render('list',array('login' => $login,'announcements' => $announcements,'name' => $name));
    }
    
     /*
     * function for getting information from sent email and open it in modal windov
     * @param $id Announcement id
     */
    public function actionUpdateAnnouncement($id, $code){
        $model = Announcement::model()->findByPk($id);
        if((!isset($model) || !isset($model->user_id) || $model->ucode != $code)
			|| (!is_null(Yii::app()->user->getId()) && Yii::app()->user->getId() != $model->user_id)){
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Je hebt geen toestemming om die operatie te doen");
            $this->redirect (Yii::app()->homeUrl);
        }
        
        if(isset($model)){
            $cs = Yii::app()->clientScript;
            $cs->registerScript('showFromEmail', 'js:navigationToView("'.Yii::app()->createUrl('announcement/update',array('id' =>$model->id)).'")', CClientScript::POS_READY);
//            $cs->registerScript('showFromEmail', 'js:navigation("'.Yii::app()->createUrl('announcement/view',array('id' =>$model->id)).'")', CClientScript::POS_READY);
        }
        
        $login = new LoginForm;
        if(!is_null(Yii::app()->user->getId())){
                    $userId = Yii::app()->user->getId();
                    $noWidgets = Yii::app()
                           ->db->createCommand(
                                   'select id,name 
                                    from lib_widgets l
                                    where id not in (
                                        select widget_id 
                                        from user_widgets
                                        where user_id = :user_id
                                    )'
                                   )
                           ->bindValues(array(':user_id'=> $userId))
                           ->queryAll();
                    foreach ($noWidgets as $noWidget){
                           switch ($noWidget['id']){
                                case LibWidgets::TOP:
                                   $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                                //"condition" => "1 = 1",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                                    if(!empty($dataTop))
                                       $widgetsData[LibWidgets::TOP] = $dataTop;
                               
                                case LibWidgets::AUTO:
                                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR)
                                                        )
                                                );
                                    if(!empty($dataAuto))
                                        $widgetsData[LibWidgets::AUTO] = $dataAuto;

                                case LibWidgets::MY_SEARCH://stex Davoin asem irany dni
                                    $dataMySearch =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "category_id = ".LibCategory::CAR,
                                                                     "order" => "view_count desc",
                                                                     "limit" => 4,
                                                                     "together" => true
                                                             )
                                                     );
                                    if(!empty($dataMySearch))
                                        $widgetsData[LibWidgets::MY_SEARCH] = $dataMySearch;
                                case LibWidgets::MY:
                                    $dataMy =  Announcement::model()->findAll(
                                                             array(
                                                                     "condition" => "1 = 1 and user_id = :user_id",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                     "params" => array(':user_id' => $userId)
                                                             )
                                                     );
                                    if(!empty($dataMy))
                                        $widgetsData[LibWidgets::MY] = $dataMy;
                                case LibWidgets::SAVED:
                                    $dataSaved =  Announcement::model()
                                                    ->with(array(
                                                        'savedAnn'=>array(
                                                            'select'=>false,
                                                            'joinType'=>'INNER JOIN',
                                                        )
                                                    ))
                                                    ->findAll(
                                                             array(
                                                                    "condition" => "`savedAnn`.user_id = :user_id",
                                                                     "order" => "rand()",
                                                                     "limit" => 4,
                                                                     "together" => true,
                                                                    "params" => array(':user_id' => $userId)
                                                             )
                                                     );
                                                 
                               if(!empty($dataSaved))
                                   $widgetsData[LibWidgets::SAVED] = $dataSaved;
                            }
                   }
                }else{
                    $dataTop =  Announcement::model()->findAll(
                                                        array(
                                                              //  "condition" => "1 = 1",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                //"together" => true
                                                        )
                                                );
                    
                    if(!empty($dataTop))
                                   $widgetsData['1'] = $dataTop;
                    
                    $dataAuto =  Announcement::model()->findAll(
                                                        array(
                                                                "condition" => "category_id = :category_id",
                                                                "order" => "view_count desc",
                                                                "limit" => 4,
                                                                "together" => true,
                                                                "params" => array(':category_id' => LibCategory::CAR)
                                                        )
                                                );
                    if(!empty($dataAuto))
                                   $widgetsData['2'] = $dataAuto;
                }
        $categories = CHtml::listData(LibCategory::model()->findAll(),'id','name');
        $this->render('index',array(
                'login' => $login,
                'widgetsData' => $widgetsData,
               // 'topAnnouncements' => $topAnnouncements,
                //'myAnnouncements' => $myAnnouncements,
                'categories' => $categories
                    )
                );
    }
    
    public function actionParent(){
        $this->layout = false;
        if(isset($_POST["id"]) && !empty($_POST["id"])){
            $parent = LibCategory::model()->findByPk($_POST["id"]);
            //$childs = CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => $parent->id)),'id','name');
            $childs = CHtml::listData($parent->childs,'id','name');
            if(isset($childs) && !empty($childs)){
                echo '<div class="parent"><br />';
                echo CHtml::dropDownList('LibCategory[parent]['.$_POST["id"].']', '',$childs,
                        array(
                            'empty' => 'Select a name',
                            'data-href' => $this->createUrl('libCategory/parent'),
                            'onchange' => 'js:change(this)',
                            )
                        );
                echo CHtml::link('remove','#',array('onclick'=>'$(this).parent().remove();'));
                echo "</div>";
            }  
        }
        Yii::app()->end();
    }
    
    public function actionParentType(){
        $this->layout = false;
        if(isset($_POST["id"]) && !empty($_POST["id"])){
            $parent = LibCategory::model()->findByPk($_POST["id"]);
            //$childs = CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => $parent->id)),'id','name');
            $childs = CHtml::listData($parent->childs,'id','name');
            if(isset($childs) && !empty($childs)){
                echo '<div class="form-group child parent_'.$_POST["id"].'"><br />';
                echo CHtml::dropDownList('LibCategory[parent]['.$_POST["id"].']', '',$childs,
                        array(
                            'empty' => 'Select type',
                            'data-href' => $this->createUrl('site/parentType'),
                            'onchange' => 'js:changeCategory(this)',
                            'class' => 'form-control',
                            'data-parent' => $_POST["id"]
                            )
                        );
               // echo CHtml::link('remove','#',array('onclick'=>'$(this).parent().remove();'));
                echo "</div>";
            }  
        }
        Yii::app()->end();
    }
    
    /*
     * 
     */
    public function actionWidget() {
        if(isset($_POST["id"]) && !empty($_POST["id"])){
            $userId = Yii::app()->user->getId();
            $widget = UserWidgets::model()->findByAttributes(array('user_id' => $userId,'widget_id' =>$_POST['id']));
            if(!isset($widget) && $_POST["status"] == 0){
                $widget = new UserWidgets;
                $widget->user_id = $userId;
                $widget->widget_id = $_POST['id'];
                $widget->save();
            }elseif (isset($widget) && $_POST["status"] == 1){
                $widget->delete();
            }
            Yii::app()->end();
        }
        Yii::app()->end();
    }
    
    
    /**
     * return result from omnikasa page
     */
    public function actionPaymentReturn($id){
        $announcement = Announcement::model()->findByPk($id);
        if(!isset($announcement)){
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Announcement not exists");
            $this->redirect (Yii::app()->homeUrl);
        }
        
        
        if(empty($_POST['Data']) || empty($_POST['Seal']))
	{
		Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "False response");
                $this->redirect (Yii::app()->homeUrl);
	}
	else
	{
		$oOmniKassa = new OmniKassa();
		$oOmniKassa->setSecurityKey(Yii::app()->params['payment']['security_key'], Yii::app()->params['payment']['security_key_version']);

		$aOmniKassaResponse = $oOmniKassa->validate();

		if($aOmniKassaResponse && is_array($aOmniKassaResponse))
		{
			// De referentiecode die bij het starten van het betaalverzoek is opgegeven, belangrijk om in de 
			// database de bijbehorende bestelling op te zoeken.
			$sTransactionReference = $aOmniKassaResponse['transaction_reference']; 

			// De huidige status van de betaalverzoek. De ontvangen responseCode wordt door de bibliotheek
			// omgezet in de waarde SUCCESS, PENDING, CANCELLED, EXPIRED of FAILED.
			$sTransactionStatus = $aOmniKassaResponse['transaction_status']; 

			// Bij sommige betaalmethoden (zoals iDEAL) wordt deze waarde gevuld met het "authorisationId", 
			// dit is de door de iDEAL server toegewezen unieke TransactionID.
			$sTransactionId = $aOmniKassaResponse['transaction_id']; 

			// Het orderID (Alleen de karakters [a-zA-Z0-9] en gelimiteerd tot 32 karakters). 
			// Door de mutaties die soms plaats vinden in dit orderID is dit doorgaans GEEN goede 
			// waarde om de bestelling op te zoeken in de database.
			$sOrderId = $aOmniKassaResponse['order_id']; 


			// Bepaal de transactie status, en bevestig deze aan de bezoeker
			if(strcmp($sTransactionStatus, 'SUCCESS') === 0)
			{
				$status = 1;
			}
			elseif(strcmp($sTransactionStatus, 'PENDING') === 0)
			{
				$status = 2;
			}
			elseif(strcmp($sTransactionStatus, 'CANCELLED') === 0)
			{
				$status = 3;
			}
			elseif(strcmp($sTransactionStatus, 'EXPIRED') === 0)
			{
				$status = 4;
			}
			else // if(strcmp($sTransactionStatus, 'FAILURE') === 0)
			{
				$status = 5;
			}
		}
		else
		{
			$status = 5;
		}
                $announcement_paid = AnnouncementPaid::model()->findByAttributes(array('announcement_id' => $announcement->id,'order_id' => $sOrderId));
                if(!isset($announcement_paid)){
                    $announcement_paid = new AnnouncementPaid;
                    $announcement_paid->announcement_id = (int)$announcement->id;
                    $announcement_paid->setIsNewRecord(true);
                }  else {
                    $announcement_paid->setIsNewRecord(false);
                }
                $announcement_paid->status = $status;
                $announcement_paid->order_id = $sOrderId;
                $announcement_paid->save();
die;                
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Your transaction has compleated");
                $this->redirect (Yii::app()->createUrl('site/show', array('id' => $announcement->id)));
	}
        
    }
     
        
}