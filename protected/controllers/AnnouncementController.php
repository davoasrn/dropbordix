<?php

class AnnouncementController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','create','update','createNotLogined',
                                                    'checkNotLogined','check','saveComment','delete',
                                                    'updateComment','deleteComment','upload',
                                                    'emailAnnouncement','checkEmail','show', 'checkEmailSpam',
                                                    'deleteImages','emailSpam','saveAnnouncement','uploadVideo'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 * 
	 */
	public function actionView($id)
	{
		if(!Yii::app()->request->isAjaxRequest){
			Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
			$this->redirect (Yii::app()->homeUrl);
		}
		$model = Announcement::model()->findByPk($id);
		if($model == null || $model->status == LibAnnouncementStatus::not_verfied){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		//announcement comments
		$comments = Comments::model()->findAllByAttributes(array('announcement_id' => $model->id));
		//new comment
		$newComment = new Comments;
                
                //same result
                $criteria = new CDbCriteria();
                //$criteria->condition='category=:category';
                $criteria->compare('category_id', $model->category_id);
                if($model->category_id != LibCategory::CAR){
                    $criteria->addSearchCondition('name', $model->name);
                }else{
                    $criteria->with = array('autoDetails');
                    if(isset($model->autoDetails) && !empty($model->autoDetails->mileage))
                        $criteria->addBetweenCondition('autoDetails.mileage', (int)$model->autoDetails->mileage - 50, (int)$model->autoDetails->mileage + 50);
                    if(isset($model->autoDetails) && !empty($model->autoDetails->fuel_id)){
                        $criteria->addCondition('`autoDetails`.fuel_id = '.$model->autoDetails->fuel_id);
                    }
                    if(isset($model->autoDetails) && !empty($model->autoDetails->transmission_id)){
                        $criteria->addCondition('`autoDetails`.transmission_id = '.$model->autoDetails->transmission_id);
                    }
                }
                
                $criteria->condition = "`t`.`id` <> ".$model->id;
                //$criteria->params = array(':id'=>$model->id);
                
                $model->view_count = (int)$model->view_count + 1;
                $model->update(array('view_count'));
                
                $criteria->limit = 4;
                $sameResult = Announcement::model()->findAll($criteria);
		
		$auto_detail = $model->autoDetails;
		$announce_paid = new AnnouncementPaid;
		$user = $model->user;
		if($user == null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
                
                $payments = Payments::model()->findAllByAttributes(
                            array(
                                'announcement_id' => $model->id
                            ),
                            array(
                                'order' => 'add_date desc',
                                'limit' => 5
                            )
                        );
                        
		$this->renderPartial('view',array(
			'model'=>$model,
                        'auto_detail' => $auto_detail,
                        'announce_paid' => $announce_paid,
                        'user' => $user,
			'comments' => $comments,
			'newComment' => $newComment,
                        'sameResult' => $sameResult,
                        'payments' => $payments
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                if(!Yii::app()->request->isAjaxRequest){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                    $this->redirect (Yii::app()->homeUrl);
                }
		$model=new Announcement;
		$auto_detail = new AutoDetail;
                $announce_paid = new AnnouncementPaid;
                $user = Users::model()->findByPk(Yii::app()->user->getId());
		if($user == null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
                $files = new Files();
                
                $path = Yii::app()->basePath.'/../images/'.$user->id."/";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Announcement']))
		{
			$model->attributes=$_POST['Announcement'];
                        $model->start_date = date('Y-m-d');
                        $model->end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 40 days'));
                        $model->status = LibAnnouncementStatus::stat_new;
                        $model->user_id = $user->id;
                        
                        //bieden
                        if(!isset($_POST['check']) || $_POST['check'] != 0){
                            $model->bid = null;
                            if($model->status ==LibAnnouncementStatus::offer)
                                $model->status = LibAnnouncementStatus::stat_new;
                        }  else {
                            $model->status = LibAnnouncementStatus::offer;
                        }
                        
                        if(isset($_POST['Announcement']['video_url']) && !empty($_POST['Announcement']['video_url']) 
                                && isset($_POST['Announcement']['video_hidden_name']) && !empty($_POST['Announcement']['video_hidden_name']))
                            $model->video_url = $_POST['Announcement']['video_hidden_name'];
                        
                        if(isset($_POST['LibCategory']))
                            $parent = array_filter($_POST['LibCategory']['parent']);
                        if(!isset($parent) || empty($parent))
                            $resultVal = $_POST['Announcement']['category_id'];
                        else{
                            if(!array_key_exists($_POST['Announcement']['category_id'],$parent))
                                $keyFirst = array_shift(array_values($parent));
                            else
                                $keyFirst = $parent[$_POST['Announcement']['category_id']];
                            $resultVal = $keyFirst;
                            for($i = 1; $i<= count($parent);$i++){
                                if(isset($parent[$resultVal]))
                                    $resultVal = $parent[$resultVal];
                            }
                        }
                        
                        $model->category_id = $resultVal;
                        //$model->video = CUploadedFile::getInstance($model,'video');
//                        $model->video=CUploadedFile::getInstance($model,'video');
//                        $name = hash('crc32', $model->video).".".$model->video->extensionName;
//                        $model->video_url = $name;
                        
                        if($model->save()){
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "e-mail verzonden");
                            
//                            if($model->video !== null){
//                                $model->video->saveAs( $path.$model->video_url);
//                            }
                            /*
                             * save Auto details
                             */
                            if(isset($_POST['AutoDetail'])){
                                $auto_detail->attributes = $_POST['AutoDetail'];
                                $auto_detail->announcement_id = $model->id;
                                $auto_detail->save();
                            }
                            
                            if(isset($_POST['File'])){
                                foreach ($_POST['File'] as $file){
                                    $resFile = Files::model()->findByPk($file['id']);
                                    if (isset($resFile)){
                                        $resFile->announcement_id = $model->id;
                                        $resFile->update(array('announcement_id'));
                                    }
                                }
                            }
                            
                            /*
                             * save announcement paid
                             */
                            if(isset($_POST['AnnouncementPaid'])){
                                $announce_paid->attributes = $_POST['AnnouncementPaid'];
                                $announce_paid->announcement_id = $model->id;
                                $announce_paid->save();
                            }
                        }
			if(!Yii::app()->request->isAjaxRequest)
                                $this->redirect(array('view','id'=>$model->id));
                        else {
                                echo CJSON::encode(array(
                                        'status'=>'saved',
                                        'id' => $model->id
                                ));
                                Yii::app()->end();
                            }
		}

		$this->renderPartial('create',array(
			'model'=>$model,
                        'auto_detail' => $auto_detail,
                        'announce_paid' => $announce_paid,
                        'user' => $user,
                        'files' => $files,
		),false, true);
	}
	
		/*
         * public function for checking, validating
         * if person logined
         * 
         */
        public function actionCheck($id=null){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            if(isset($id) && !empty($id)){
                $model = Announcement::model()->findByPk($id);
            }else
                $model=new Announcement;
            $model->scenario = 'create';
            $auto_detail = new AutoDetail;
            $auto_detail->scenario = 'create';
            $announce_paid = new AnnouncementPaid;
            $users = Users::model()->findByPk(isset($id) ? $model->user_id : Yii::app()->user->getId());
			if($users == null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
            $this->performAjaxValidation($model);  
            
            if(isset($_POST['Announcement']))
            {
                    $model->attributes=$_POST['Announcement'];
                    $validAnn = $model->validate();            
            }
            
            if(isset($_POST['AutoDetail']))
            {
                        $auto_detail->attributes=$_POST['AutoDetail'];
                        $validUser=$users->validate();            
            }
               
            $error = CActiveForm::validate(array($model,$auto_detail));
            
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateNotLogined()
	{
                if(!Yii::app()->request->isAjaxRequest){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                    $this->redirect (Yii::app()->homeUrl);
                }
		$model=new Announcement;
                $auto_detail = new AutoDetail;
                $announce_paid = new AnnouncementPaid;
                $users = new Users;
                $files = new Files();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);               
                
		if(isset($_POST['Announcement']))
		{
                        /*
                        * save user without any registration
                        */
                        if(isset($_POST['Users'])){
                            $users->scenario = 'notLogined';
                            $users = Users::model()->findByAttributes(array('email'=>$_POST['Users']['email']));
                            if(!isset($users))
                                $users = new Users;
                            $users->attributes = $_POST['Users'];
                            $users->type = Users::ROLE_USER_NOT_LOGINED;
                            $users->save();
                            $folder=Yii::getPathOfAlias('webroot.images').DIRECTORY_SEPARATOR;// folder for uploaded files
                            if(!is_dir($folder.$users->id)){
                                    mkdir($folder.$users->id);
                                    mkdir($folder.$users->id.'/thumbs/');
                            }
                        }
                        
			$model->attributes=$_POST['Announcement'];
                        $model->start_date = date('Y-m-d');
                        $model->end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 40 days'));
                        $model->status = LibAnnouncementStatus::not_verfied;
                        //bieden
                        if(!isset($_POST['check']) || $_POST['check'] != 0){
                            $model->bid = null;
                            if($model->status ==LibAnnouncementStatus::offer)
                                $model->status = LibAnnouncementStatus::not_verfied;
                        }  else {
                            $model->status = LibAnnouncementStatus::offer;
                        }
                        
                        if(isset($_POST['Announcement']['video_url']) && !empty($_POST['Announcement']['video_url']) 
                                && isset($_POST['Announcement']['video_hidden_name']) && !empty($_POST['Announcement']['video_hidden_name']))
                            $model->video_url = $_POST['Announcement']['video_hidden_name'];
                        
                        if(isset($_POST['LibCategory']))
                            $parent = array_filter($_POST['LibCategory']['parent']);
                        if(!isset($parent) || empty($parent))
                            $resultVal = $_POST['Announcement']['category_id'];
                        else{
                            if(!array_key_exists($_POST['Announcement']['category_id'],$parent))
                                $keyFirst = array_shift(array_values($parent));
                            else
                                $keyFirst = $parent[$_POST['Announcement']['category_id']];
                            $resultVal = $keyFirst;
                            for($i = 1; $i<= count($parent);$i++){
                                if(isset($parent[$resultVal]))
                                    $resultVal = $parent[$resultVal];
                            }
                        }
                        
                        $model->category_id = $resultVal;
                        //$model->category_id = 1;
                        $model->user_id = $users->id;
                        
                        
                        
                        if($model->save()){
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Uw aankondiging succesvol opgeslagen");
                            /*
                             * save Auto details
                             */
                            if(isset($_POST['AutoDetail'])){
                                $auto_detail->attributes = $_POST['AutoDetail'];
                                $auto_detail->announcement_id = $model->id;
                                $auto_detail->save();
                            }
                            
                            if(isset($_POST['File'])){
                                foreach ($_POST['File'] as $file){
                                    $resFile = Files::model()->findByPk($file['id']);
                                    if (isset($resFile)){
                                        $resFile->announcement_id = $model->id;
                                        $resFile->update(array('announcement_id'));
                                        if(file_exists(Yii::app()->basePath.'/../images/'.$resFile->name)){
                                            copy(Yii::app()->basePath.'/../images/'.$resFile->name, Yii::app()->basePath.'/../images/'.$users->id."/".$resFile->name);
                                            unlink(Yii::app()->basePath.'/../images/'.$resFile->name);
                                        }
                                        if(file_exists(Yii::app()->basePath.'/../images/thumbs/'.$resFile->name)){
                                            copy(Yii::app()->basePath.'/../images/thumbs/'.$resFile->name, Yii::app()->basePath.'/../images/'.$users->id."/thumbs/".$resFile->name);
                                            unlink(Yii::app()->basePath.'/../images/thumbs/'.$resFile->name);
                                        }
                                    }
                                }
                            }
                            
                            /*
                             * save announcement paid
                             */
                            if(isset($_POST['AnnouncementPaid'])){
                                $announce_paid->attributes = $_POST['AnnouncementPaid'];
                                $announce_paid->announcement_id = $model->id;
                                $announce_paid->save();
                            }
                            
                              /*
                            *
                            *check the condition for search me
                            *
                            */
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "t.id =".$model->id ;
                        $ct= new CDbCriteria();                                   

                        $ct->select = "t.id ,t.email";
                        

                         $searchMe = SearchMe::model()->findAll();

                         foreach($searchMe as $param)
                         {
                               $query = new CDbCriteria;
                                    //$query->select = 'lbt.* ';
                                    $query->join = ' LEFT JOIN `auto_detail` AS `ad` ON t.id = ad.announcement_id';
                                    $query->join.= " LEFT JOIN `users` AS `u` ON u.id = t.user_id ";
                                    $query->join.= " LEFT JOIN `lib_fuel_types` AS `lbt` ON lbt.id = ad.fuel_id ";



                                    if(!empty($param["trefwoord1"]))
                                    {

                                        $condition=" t.id =".$model->id." and ( t.name like '".$param["trefwoord1"]."%' or t.description like '".$param["trefwoord1"]."%' )";


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



                                    if(!empty($data['results']))
                                    {
                                         $ct->addCondition('id='.$param["id"],'or');
                                    }


                                }
                                 $data['searchMe'] = SearchMe::model()->findAll($ct);
                                 if(!empty($data['searchMe']))
                                 {
                                    foreach($data['searchMe'] as $search)
                                    {
                                        $search_me=$search->attributes;

                                        $ToEmail ='gtugam@gmail.com';// //Yii::app()->Smtpmail;
                                        $EmailSubject = 'vragen of opmerkingen'; 
                                        $mailheader = "From: ".$search_me["email"]."\r\n"; 
                                        $MESSAGE_BODY= nl2br(CHtml::link('show announcement',Yii::app()->params['siteUrl'].Yii::app()->createUrl('site/show',array('id' =>$model->id)))." \r\n");
                                        $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
                                          //$MESSAGE_BODY = "Telefoonnummer : ".$model->phone."\r\n"; 
                                          //$MESSAGE_BODY .= "Comment: ".nl2br($model->comments).""; 
                                        mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader);
                                    }
                                 }                                                    
                        }
			if(!Yii::app()->request->isAjaxRequest)
                                $this->redirect(array('view','id'=>$model->id));
                        else {
                                echo CJSON::encode(array(
                                        'status'=>'saved',
                                        'id' => $model->id
                                ));
                                Yii::app()->end();
                            }
		}

		$this->renderPartial('create_not_logined',array(
			'model'=>$model,
                        'auto_detail' => $auto_detail,
                        'announce_paid' => $announce_paid,
                        'users' => $users,
                        'files' => $files,
		),false, true);
	}
        
        /*
         * public function for checking, validating
         * if form on not logined page filled correct
         * 
         */
        public function actionCheckNotLogined(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            $model=new Announcement;
            $model->scenario = 'notLogined';
            $auto_detail = new AutoDetail;
            $auto_detail->scenario = 'notLogined';
            $announce_paid = new AnnouncementPaid;
            $users = new Users;
            $users->scenario = 'notLogined';
            $this->performAjaxValidation($model);  
            
            if(isset($_POST['Announcement']))
            {
                    $model->attributes=$_POST['Announcement'];
                    $validAnn = $model->validate();            
            }
            if(isset($_POST['Users']))
            {
                        $users->attributes=$_POST['Users'];
                        $validUser=$users->validate();            
            }
            if(isset($_POST['AutoDetail']))
            {
                        $auto_detail->attributes=$_POST['AutoDetail'];
                        $validUser=$users->validate();            
            }
               
            $error = CActiveForm::validate(array($users,$model,$auto_detail));
            
            if($error!='[]')
                echo $error;
            else {
                echo CJSON::encode(array(
                    'status'=>'success'
                ));
            }
            Yii::app()->end();
        }
        
        public function actionDeleteImages() {
            if(isset($_POST['id']) && isset($_POST['path']) && is_numeric($_POST['id'])){
                $file = Files::model()->findByPk($_POST['id']);
                $file->delete();
                if(file_exists(Yii::app()->basePath.'/..'.$_POST['path']))
                    unlink(Yii::app()->basePath.'/..'.$_POST['path']);
                Yii::app()->end();
            }
        }
        
        
        public function actionUpload(){
            $action = $_POST['action'];
            if($action == 'update'){
                $id = $_POST['id'];
                $model=$this->loadModel($id); 
                $user = $model->user;
                if($user == null){
                    throw new CHttpException(404,'The requested page does not exist.');
                }
                $path = Yii::app()->basePath.'/../images/'.$user->id."/";
                $pathThub = Yii::app()->basePath.'/../images/'.$user->id."/thumbs/";
            }elseif ($action == 'createNotLogined') {
                $path = Yii::app()->basePath.'/../images/';
                $pathThub = Yii::app()->basePath.'/../images/thumbs/';
            }elseif ($action == 'create') {
                $path = Yii::app()->basePath.'/../images/'.Yii::app()->user->getId()."/";
                $pathThub = Yii::app()->basePath.'/../images/'.Yii::app()->user->getId()."/thumbs/";
            }
                
            $files = new Files();
            $splitName = explode('.', $_FILES['Files']['name']);
            $extension = end($splitName);
            
            
            $name = hash('crc32', reset($splitName)).".".$extension;
            
            //$name = hash('crc32', $files->photo).".".$files->photo->extensionName;
            
            //$files->photo=CUploadedFile::getInstance($files,'photo');
            
            //$name = hash('crc32', $files->photo).".".$files->photo->extensionName;
            $files->name = $name;
            
            if(!$files->save() || !move_uploaded_file($_FILES['Files']['tmp_name'], $path.$name)){
              throw new CHttpException(500);
            }else{
                if(!is_dir($pathThub)){
                        mkdir($pathThub);
                }
                $image = Yii::app()->image->load($path.$files->name);
                $image->resize(300, 100)->quality(75)->sharpen(20);
                $image->save($pathThub.$files->name);
            }
            echo $files->id."-".$files->name;
            Yii::app()->end();
        }
        
        /**
         * upload vide by uploadify
         */
        public function actionUploadVideo(){
            $action = $_POST['action'];
            if($action == 'update'){
                $id = $_POST['id'];
                $model=$this->loadModel($id); 
                $user = $model->user;
                if($user == null){
                    throw new CHttpException(404,'The requested page does not exist.');
                }
                $path = Yii::app()->basePath.'/../images/'.$user->id."/";
            }elseif ($action == 'createNotLogined') {
                $path = Yii::app()->basePath.'/../images/';
            }elseif ($action == 'create') {
                $path = Yii::app()->basePath.'/../images/'.Yii::app()->user->getId()."/";
            }
                
            $files = new Files();
            $splitName = explode('.', $_FILES['Files']['name']);
            $extension = end($splitName);
            
            $name = hash('crc32', reset($splitName)).".".$extension;
            $files->name = $name;
            $files->type = 1;
            
            if(!$files->save() || !move_uploaded_file($_FILES['Files']['tmp_name'], $path.$name)){
              throw new CHttpException(500);
            }
            
            echo $files->id."-".$files->name;
            Yii::app()->end();
        }
        

        /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id=null)
	{
                if(!Yii::app()->request->isAjaxRequest){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                    $this->redirect (Yii::app()->homeUrl);
                }
                $id = !isset($id) ? $_POST['id'] : $id;
		$model=$this->loadModel($id);
                
                $auto_detail = $model->autoDetails;
                if(!isset($auto_detail))
                    $auto_detail = new AutoDetail;
                
		$announce_paid = new AnnouncementPaid;
                
		$user = $model->user;
                if(!isset($user))
                    $user = new Users;
                
		if($user == null){
			throw new CHttpException(404,'The requested page does not exist.');
		}
                $uploadedFiles = Files::model()->findAllByAttributes(array('announcement_id' => $model->id));
                $files = new Files();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Announcement']))
		{
			$model->attributes=$_POST['Announcement'];
                        //bieden
			if(!isset($_POST['check']) || $_POST['check'] != 0){
				$model->bid = null;
				if($model->status ==LibAnnouncementStatus::offer)
					$model->status = LibAnnouncementStatus::stat_new;
			}  elseif($model->status ==LibAnnouncementStatus::stat_new) {
				$model->status = LibAnnouncementStatus::offer;
			}
			
			if(isset($_POST['Announcement']['video_url']) && !empty($_POST['Announcement']['video_url']) 
					&& isset($_POST['Announcement']['video_hidden_name']) && !empty($_POST['Announcement']['video_hidden_name']))
				$model->video_url = $_POST['Announcement']['video_hidden_name'];
			
			if(isset($_POST['LibCategory']))
				$parent = array_filter($_POST['LibCategory']['parent']);
			if(!isset($parent) || empty($parent))
				$resultVal = $_POST['Announcement']['category_id'];
			else{
				if(!array_key_exists($_POST['Announcement']['category_id'],$parent))
					$keyFirst = array_shift(array_values($parent));
				else
					$keyFirst = $parent[$_POST['Announcement']['category_id']];
				$resultVal = $keyFirst;
				for($i = 1; $i<= count($parent);$i++){
					if(isset($parent[$resultVal]))
						$resultVal = $parent[$resultVal];
				}
			}
			
			$model->category_id = $resultVal;
			if($model->save()){
				
				$annPays = Payments::model()->findAll(array(
								'select' => 't.email',
								'distinct' => true,
								'condition' => 'announcement_id = :announcement_id',
								'params' => array(':announcement_id' => $model->id)
							));
				
				if($model->status == LibAnnouncementStatus::reserved){
					$file = '//email/reserved';
				}elseif($model->status == LibAnnouncementStatus::sold){
					$file = '//email/sold';
				}
				
				foreach($annPays as $annPay){
					$mailer = null;
					$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
					$mailer->From = Yii::app()->params['adminEmail'];
					$mailer->AddReplyTo($annPay->email);
					$mailer->AddAddress($annPay->email);
					$mailer->FromName = 'Dropbord.nl';
					$mailer->CharSet = 'UTF-8';
					$mailer->Subject =  $model->name;
					$mailer->MsgHTML($this->render($file, array(
											'model'=> $model)
										, true
									   ));
					$mailer->Send();
				}
				
				
				/*
				 * save Auto details
				*/
				if($_POST['AutoDetail'] != 1 && isset($_POST['AutoDetail'])){
					$auto_detail->attributes = $_POST['AutoDetail'];
					$auto_detail->announcement_id = $model->id;
					$auto_detail->save();
				}
				
				if($model->category_id != LibCategory::CAR && isset($model->autoDetails)){
					$model->autoDetails->delete();
				}
				
				if(isset($_POST['File'])){
					foreach ($_POST['File'] as $file){
						$resFile = Files::model()->findByPk($file['id']);
						if (isset($resFile)){
							if($resFile->announcement_id == null){
									$resFile->announcement_id = $model->id;
									$resFile->update(array('announcement_id'));
							}
						}
					}
				}
				
				/*
				 * save announcement paid
				 */
				if(isset($_POST['AnnouncementPaid'])){
					$announce_paid->attributes = $_POST['AnnouncementPaid'];
					$announce_paid->announcement_id = $model->id;
					$announce_paid->save();
				}
			}
			if(!Yii::app()->request->isAjaxRequest)
					$this->redirect(array('view','id'=>$model->id));
			else {
//                            $this->redirect(array('site/show','id'=>$model->id));
				
					echo CJSON::encode(array(
							'status'=>'saved',
							'id' => $model->id
					));
					Yii::app()->end();
				}
		}

		$this->renderPartial('update',array(
			'model'=>$model,
                        'auto_detail' => $auto_detail,
                        'announce_paid' => $announce_paid,
                        'user' => $user,
                        'files' => $files,
                        'uploadedFiles' => $uploadedFiles,
		),false, true);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $code)
	{
                $model = $this->loadModel($id);
                if((!isset($model) || !isset($model->user_id) || $model->ucode != $code)
					|| (!is_null(Yii::app()->user->getId()) && Yii::app()->user->getId() != $model->user_id)){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Je hebt geen toestemming om die operatie te doen");
                    $this->redirect (Yii::app()->homeUrl);
                }
	
                //if($model->category_id == LibCategory::CAR){
                    $carData = AutoDetail::model()->deleteAllByAttributes(array('announcement_id' => $model->id));
                //}
                
                /*deleteing files*/
                $files = $model->files;
                $imagePath = Yii::app()->basePath.'/../images/'.$model->user_id."/";
                $imageThumb = Yii::app()->basePath.'/../images/'.$model->user_id."/thumbs/";
                foreach ($files as $file){
                    if(file_exists($imageThumb.$file->name))
                            @unlink ($imageThumb.$file->name);
                    if(file_exists($imagePath.$file->name))
                            @unlink ($imagePath.$file->name);
                    $file->delete();
                }
                /*delete saved announcement*/
                foreach($model->savedAnn as $saved)
                    $saved->delete();
                /*delete payments*/
                foreach($model->payments as $payment)
                    $payment->delete();
                /*delete comments*/
                foreach($model->comments as $comment)
                    $comment->delete();
                
		$this->loadModel($id)->delete();
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Uw aankondiging succesvol verwijderd");
                $this->redirect (Yii::app()->homeUrl);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Announcement');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Announcement('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Announcement']))
			$model->attributes=$_GET['Announcement'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Announcement the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Announcement::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Announcement $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='announcement-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/*
	*action for checking comment true validation
	*/
	public function actionCheckComment(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
		$model = new Comments;
		if(isset($_POST['Comment']))
            {
		$model->attributes=$_POST['Comment'];
                $validate = $model->validate();            
            }
		
            if($error!='[]')
                echo $error;
            else {
                echo CJSON::encode(array(
                    'status'=>'success'
                ));
            }
            Yii::app()->end();
		
	}
	
	/*
	*action for saving comments in Comments table
	*/
	public function actionSaveComment(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
		$model = new Comments;

		if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Comments']) && !empty($_POST['Comments']['text']))
		{
			if(isset($_POST['Comments']['id']) && !empty($_POST['Comments']['id']))
				$model = Comments::model()->findByPk($_POST['Comments']['id']);
				
			$model->attributes=$_POST['Comments'];
			
			if( !empty($_POST['Comments']['text'])){
				$model->save();
				$model = new Comments;
			}
				
		}
		$announcement = Announcement::model()->findByPk(isset($model->announcement_id) ? $model->announcement_id : $_POST['Comments']['announcement_id']);
		$comments = Comments::model()->findAllByAttributes(array('announcement_id' => $announcement->id));
		//new comment
		

		echo $this->renderPartial('comment',
								array(
									'comments' =>$comments,	
									'model' => $model,
									'announcement' =>$announcement
									),false,true);

		Yii::app()->end();
	}
	
	/*
	*Function for deleting Comment from table
	*@param integer $id, Comment id, to be deleted
	*/
	/*
	public function actionDeleteComment($id){
		$modelDel = Comments::model()->findByPk($id);
		$model = new Comments;
		if(isset($modelDel)){
			$announcement = Announcement::model()->findByPk($modelDel->announcement_id);
			if($modelDel->user_id === Yii::app()->user->getId())
				$modelDel->delete();
			
			$comments = Comments::model()->findAllByAttributes(array('announcement_id' => $announcement->id));
			echo $this->renderPartial('comment',
							array(
								'comments' =>$comments,
								'model' => $model,
								'announcement' =>$announcement,
							),false,true);
		}
	
		//Yii::app()->end();
	} */
	
	public function actionDeleteComment(){
                if(!Yii::app()->request->isAjaxRequest){
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                    $this->redirect (Yii::app()->homeUrl);
                }
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$id = $_POST['id'];
			$modelDel = Comments::model()->findByPk($id);
		}
		
		$model = new Comments;
		if(isset($modelDel)){
			$announcement = Announcement::model()->findByPk($modelDel->announcement_id);
			if($modelDel->user_id === Yii::app()->user->getId())
				$modelDel->delete();
			
			$comments = Comments::model()->findAllByAttributes(array('announcement_id' => $announcement->id));
			echo $this->renderPartial('comment',
							array(
								'comments' =>$comments,
								'model' => $model,
								'announcement' =>$announcement,
							),false,true);
		}
	
		//Yii::app()->end();
	}
        
        public function actionUpload2(){
            $model = new Files;
            if(isset($_POST['Files'])){
                    $model->name=CUploadedFile::getInstance($model,'name');
                    $model->announcement_id = 9;
                    if(!$model->save() || !$model->name->saveAs( Yii::app()->basePath.'/../images/'.$user->id."/".$model->name))
                      throw new CHttpException(500);
                    echo 1;
                    Yii::app()->end();
                  }
                   
        }
        
        /*
         * send announcement link to friend
         */
        public function actionEmailAnnouncement($id){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            $model = $this->loadModel($id);
            $sendModel = new EmailAnnouncement();
            $sendModel->scenario = 'email';
            if(isset($_POST['EmailAnnouncement']))
            {
                $sendModel->attributes=$_POST['EmailAnnouncement'];
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
                echo CJSON::encode(array(
                        'status'=>'saved',
                        'id' => $model->id
                ));
                Yii::app()->end();
            }
            $this->renderPartial('emailAnnouncement',array('model'=>$model,'sendModel' => $sendModel),false, true);
                   
        }
        
        /*
         * send announcement link to friend
         */
        public function actionEmailSpam($id){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            $model = $this->loadModel($id);
            $sendModel = new EmailAnnouncement();
            $sendModel->scenario = 'spam';
            if(isset($_POST['EmailAnnouncement']))
            {
                $sendModel->attributes=$_POST['EmailAnnouncement'];
                $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                $mailer->From = $sendModel->emailFrom;
                $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
                $mailer->AddAddress(Yii::app()->params['adminEmail']);
                $mailer->FromName = $sendModel->name;
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = Yii::t('dropbord.nl', $model->name);
                $mailer->MsgHTML($this->render('//email/emailAboutAnnouncementTo', array(
                                        'model'=> $model)
                                    , true
                                   ));
                if($mailer->Send())
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Uw e-mail succesvol verzonden");
                echo CJSON::encode(array(
                        'status'=>'saved',
                        'id' => $model->id
                ));
                Yii::app()->end();
            }
            $this->renderPartial('emailSpam',array('model'=>$model,'sendModel' => $sendModel),false, true);
                   
        }
        
        /*
         * send announcement link to friend
         */
        public function actionCheckEmail(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            $model = new EmailAnnouncement();
            $model->scenario = 'email';
            if(isset($_POST['EmailAnnouncement']))
            {
                $model->attributes=$_POST['EmailAnnouncement'];
                $error = CActiveForm::validate(array($model));
            
                if($error!='[]')
                    echo $error;
                else {
                    echo CJSON::encode(array(
                        'status'=>'success'
                    ));
                }
            }
		
            
            Yii::app()->end();
                   
        }
        /*
         * send announcement link to friend
         */
        public function actionCheckEmailSpam(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            $model = new EmailAnnouncement();
            $model->scenario = 'spam';
            if(isset($_POST['EmailAnnouncement']))
            {
                $model->attributes=$_POST['EmailAnnouncement'];
                $error = CActiveForm::validate(array($model));
            
                if($error!='[]')
                    echo $error;
                else {
                    echo CJSON::encode(array(
                        'status'=>'success'
                    ));
                }
            }
		
            
            Yii::app()->end();
                   
        }
        
        /*
         * function which calls from ajax, in announcement view page
         * it saves announcement for user
         */
        public function actionSaveAnnouncement(){
            if(!Yii::app()->request->isAjaxRequest){
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
                $this->redirect (Yii::app()->homeUrl);
            }
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $userId = Yii::app()->user->getId();
                $return = false;
                $saveAnnouncement = SavedAnnouncements::model()->findByAttributes(array('user_id' => $userId,'announcement_id' =>$_POST['id']));
                if(isset($saveAnnouncement)){
                    if($saveAnnouncement->delete())
                        echo 'Aankondiging verwijderd uit uw favorieten';
                }else{
                    $saveAnnouncement = new SavedAnnouncements;
                    $saveAnnouncement->announcement_id = $_POST['id'];
                    $saveAnnouncement->user_id = $userId;
                    if($saveAnnouncement->save()){
                        echo 'Aankondiging opgeslagen in uw favorieten';
                    }
                }
            }
            
            Yii::app()->end();
        }
        
       
}
