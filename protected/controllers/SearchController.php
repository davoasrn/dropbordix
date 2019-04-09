<?php

class SearchController extends Controller
{
    	public $layout='//layouts/column2';
        
        public function init(){
            if(isset($_POST['SESSION_ID'])){
              $session=Yii::app()->getSession();
              $session->close();
              $session->sessionID = $_POST['SESSION_ID'];
              $session->open();
            }
        }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

		public function accessRules()
	    {
    		return array(
    			array('allow',  // allow all users to perform 'index' and 'view' actions
    				'actions'=>array('searchMe','valid'),
    				'users'=>array('*'),
    			),
    			array('allow', // allow authenticated user to perform 'create' and 'update' actions
    				'actions'=>array('searchMe','valid'),
    				'users'=>array('@'),
    			),
    			array('allow', // allow admin user to perform 'admin' and 'delete' actions
    				'actions'=>array('searchMe','valid'),
    				'users'=>array('admin'),
    			),
    			array('deny',  // deny all users
                'actions'=>array('searchMe','valid'),
    				'users'=>array('*'),
    			),
    		);
    	}
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
		),false,false); //Yii::app()->request->isAjaxRequest
        	
	
	   }   
    /*
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
           
	}*/
    	public function actionSearchMe()
        {
			$model=new Search();
            if(isset($_POST['Search']))
            {
             
					$search=$model->attributes=$_POST['Search'];
                    $zipcode=$search["zipcode"];
                    $range=(int)$search["range"];
					$criteria = new CDbCriteria();
                 
					if(!empty($search["trefwoord1"])){
						$criteria->compare('t.name', $search["trefwoord1"], true);
					}
                     
					$data['results'] = Announcement::model()->with('user')->with('autoDetails')->findAll($criteria);
							 
					if($search["zipcode"] == NULL){
						$data['lat'] = '';
						$data['lng'] = '';
						$data['limit']    =   '';
					}else if($zipcode == '1234 XX'){
						$data['lat'] = '';
						$data['lng'] = '';
						$data['limit']    =   '';
					} else {
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
						}else {
							die('post_code_error');
						}
					}
					
					$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
					$mailer->From = Yii::app()->params['adminEmail'];
					$mailer->AddReplyTo($model->email);
					$mailer->AddAddress($model->email);
					$mailer->FromName = 'Dropbord.nl';
					$mailer->CharSet = 'UTF-8';
					$mailer->Subject =  $model->announcement->name;
					$mailer->MsgHTML($this->render('//email/search_me', array(
											'model'=> $model)
										, true
									   ));
					$mailer->Send();
					
					
					$ToEmail ='gtugam@gmail.com'; //Yii::app()->Smtpmail;
					$EmailSubject = 'vragen of opmerkingen'; 
					$mailheader = "From: "."gtugam@gmail.com"."\r\n"; 
					//$mailheader .= "Reply-To:  \r\n"; 
					$mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					// $MESSAGE_BODY = "Telefoonnummer : ".$model->phone."\r\n"; 
					$MESSAGE_BODY .= "link: ".nl2br($model->comments).""; 
					mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader);

					if(!Yii::app()->request->isAjaxRequest)
											$this->redirect(array('index'));
					else {
											echo CJSON::encode(array(
													'status'=>'saved'
							));
							Yii::app()->end();
					}
                     
                    $valid=$model->validate(); 
                                
            }
        		
            $this->renderPartial('searchMe',array(
                'model'=>$model,
                ),false,true);
                //$this->render('searchMe');
        }
		
		
       	public function actionValid()
        	{
        	     $model=new Search();
                 $model->scenario='searchMe';
                 
             if(isset($_POST['Search']))
                {
                    
                 $model->attributes=$_POST['Search'];
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
            
       
        protected function performAjaxValidation($model)
        {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'father-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
      
        
}