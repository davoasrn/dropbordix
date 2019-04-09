<?php
if($model->type == 3)
    $photo = $model->photo; 
elseif (isset($model->photo) && !empty($model->photo) && file_exists(Yii::app()->basePath.'/../images/'.$model->id."/".$model->photo )) {
    $photo = '/images/'.$model->id."/".$model->photo;
}else
    $photo = Yii::app()->theme->baseUrl.'/img/user-img.png';

?>
<div class="adv-user-info-wrapper">
	<div class="adv-user-img">
		<img src="<?php echo $photo; ?>">
	</div>
	<div class="adv-user-info">
		<p>U bent ingelogd als:</p>
		<h5><?php echo CHtml::encode($model->name); ?><br><span>4,5 jaar actief op DB</span></h5>
		<p><strong><?php echo  CHtml::encode($model->phone); ?></strong></p>
						
		<p>
		<?php 
                if((!is_null(Yii::app()->user->getId()) && isset($announcement->user_id) && Yii::app()->user->getId() == $announcement->user_id))
                echo CHtml::link('Klik hier om uw<br>gegevens te wijzigen',array('site/updateAnnouncement','id'=>$announcement->id),array(/*'onclick' => 'js:navigation(this)',*/'data-href' =>  Yii::app()->createUrl('users/update',array('id' =>Yii::app()->user->getId())))); 
                
                if(isset($announcement->user_id)){
                    echo "<br />";
                    echo CHtml::link('Bekijk alle advertenties van deze gebruiker',array('site/userAnnouncements','id'=>$announcement->user_id),array('data-href' =>  Yii::app()->createUrl('users/userAnnouncements',array('id' =>$announcement->user_id)))); 
                }
                ?>
		</p>
	</div>
</div>