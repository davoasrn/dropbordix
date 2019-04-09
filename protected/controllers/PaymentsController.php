<?php

class PaymentsController extends Controller
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
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','paymentReturn'),
				'users'=>array('@'),
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
		if(!Yii::app()->request->isAjaxRequest){
			Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Wrong Action");
			$this->redirect (Yii::app()->homeUrl);
		}
		$model=new Payments;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Payments']))
		{
			$model->attributes=$_POST['Payments'];
			if($model->validate()){
				if($model->save()){
					/*send email to email, which was written in bid form*/
					$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
					$mailer->From = Yii::app()->params['adminEmail'];
					$mailer->AddReplyTo($model->email);
					$mailer->AddAddress($model->email);
					$mailer->FromName = 'Dropbord.nl';
					$mailer->CharSet = 'UTF-8';
					$mailer->Subject =  $model->announcement->name;
					$mailer->MsgHTML($this->render('//email/madeBid', array(
											'model'=> $model)
										, true
									   ));
					$mailer->Send();
					
					/*send email to others who want to buy that announcement too */
					$annPays = Payments::model()->findAll(array(
									'condition' =>'announcement_id = :announcement_id and id != :id and email != :email',
									'params' => array(
											':announcement_id' => $model->announcement_id,
											':id' => $model->id,
											':email' => $model->email
											)
								));
					if(isset($annPays) && !empty($annPays)){
						
						foreach($annPays as $anPay){
							$mailer = null;
							$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
							$mailer->From = Yii::app()->params['adminEmail'];
							$mailer->AddReplyTo($anPay->email);
							$mailer->AddAddress($anPay->email);
							$mailer->FromName = 'Dropbord.nl';
							$mailer->CharSet = 'UTF-8';
							$mailer->Subject = $model->announcement->name;
							$mailer->MsgHTML($this->render('//email/overBid', array(
													'model'=> $model)
												, true
											   ));
							$mailer->Send();
							
						}
					}
					
				}
			}
		}
                $payments = Payments::model()->findAllByAttributes(
                            array(
                                'announcement_id' => $_POST['Payments']['announcement_id']
                            ),
                            array(
                                'order' => 'add_date desc',
                                'limit' => 5
                            )
                        );

		echo $this->renderPartial('view',array(
			'payments'=>$payments,
		));
                Yii::app()->end();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Payments']))
		{
			$model->attributes=$_POST['Payments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('Payments');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Payments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Payments']))
			$model->attributes=$_GET['Payments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Payments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Payments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Payments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
     /**
     * return result from omnikasa page
      * @param int $id Announcement
      * @param int $type 1 - video, 2- site
     */
    public function actionPaymentReturn($id,$type){
        $announcement = Announcement::model()->findByPk($id);
        $omnikassa = LibOmnikassa::model()->findByAttributes(array('status' => 1));
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
		$oOmniKassa->setSecurityKey($omnikassa->security_key, $omnikassa->security_key_version);
                
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
                $announcement_paid = AnnouncementPaid::model()->findByAttributes(array('announcement_id' => $announcement->id, 'type_id' => $type));
                if(!isset($announcement_paid)){
                    $announcement_paid = new AnnouncementPaid;
                    $announcement_paid->announcement_id = (int)$announcement->id;
                    $announcement_paid->setIsNewRecord(true);
                } else {
                    $announcement_paid->setIsNewRecord(false);
                }
                $announcement_paid->status = $status;
                $announcement_paid->type_id = (int)$type;
                $announcement_paid->order_id = isset($sOrderId) ? $sOrderId : "";
                $announcement_paid->save();

                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, "Your transaction has compleated");
                $this->redirect (Yii::app()->createUrl('site/show', array('id' => $announcement->id)));
	}
        
    }
}
