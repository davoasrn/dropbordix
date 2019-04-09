<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','register','checkRegister','checkLogin'),
				'users'=>array('*'),
			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;
                $model->scenario = "create";
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
                        $model->scenario = "create";
			if($model->save()){
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Je hebt met succes geregistreerd op onze site. En je zult mail krijgt over");
                            $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
                            $mailer->From = 'info@dropbord.nl';
                            $mailer->AddReplyTo($model->email);
                            $mailer->AddAddress($model->email);
                            $mailer->FromName = 'info@dropbord.nl';
                            $mailer->CharSet = 'UTF-8';
                            $mailer->Subject = Yii::t('dropbord.nl', 'Regisiotration');
                            $mailer->MsgHTML($this->render('//email/registration', array()
                                                , true
                                               ));
                            $mailer->Send();

                            if(Yii::app()->request->isAjaxRequest)
                            {
                                echo CJSON::encode(array(
                                        'status'=>'saved'
                                   ));
                                Yii::app()->end();
                            }
                        }
                        //$this->redirect('/index');
		}
                $this->redirect(Yii::app()->homeUrl);

//		$this->render('create',array(
//			'model'=>$model,
//		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
//		 Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
                 
                 $oldphoto = $model->photo;
                 
		if(isset($_POST['Users']))
		{
                    $model->attributes=$_POST['Users'];
                    $model->scenario = 'notLogined';
                    
                    $model->photo = CUploadedFile::getInstance($model,'photo');
                    $valid=$model->validate();  
                    
		    if($valid){
                            $model->save();
                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "JJe hebt met succes je profiel bijgewerkt.");
                            $folder=Yii::getPathOfAlias('webroot.images').DIRECTORY_SEPARATOR;// folder for uploaded files

                            // you can use the ID or any property that is unique to the model
                            
                            if(!is_dir($folder.$model->id)){
                                    mkdir($folder.$model->id);
                            }

                            if(isset($model->photo) && $model->photo != $oldphoto){
                                @unlink(Yii::app()->basePath.'/../images/'.$model->id."/".$oldphoto);
                                $model->photo->saveAs( Yii::app()->basePath.'/../images/'.$model->id."/".$model->photo );
                            }
                            
                          
                            if(!Yii::app()->request->isAjaxRequest){
                                $this->redirect(Yii::app()->homeUrl);
                            }else {
                                    echo CJSON::encode(array(
                                        'status'=>'saved'
                                    ));
                                    Yii::app()->end();
                            }
                        }else{
                            $error = CActiveForm::validate($model);
                                if($error!='[]')
                                    echo $error;
                                Yii::app()->end();
                        }
		}

                $this->renderPartial('update',array('model'=>$model), false, true);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        /*
         * Check Registration rules
         */
        public function actionCheckRegister(){
                $model=new Users;
                $this->performAjaxValidation($model);  
                
                
                if(isset($_POST['Users']))
                {
                        $model->attributes=$_POST['Users'];
                        $valid=$model->validate();            
                        if($valid){
                                          
                           //do anything here
                             echo CJSON::encode(array(
                                  'status'=>'success'
                             ));
                            Yii::app()->end();
                            }
                            else{
                                $error = CActiveForm::validate($model);
                                if($error!='[]')
                                    echo $error;
                                Yii::app()->end();
                            }
               }
        }
        
        /*
         *Check user email if exists allow to submit
         *  
         */
        public function actionCheckLogin(){
            $model=new LoginForm;
            $model->attributes = $_POST['LoginForm'];
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
       	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
