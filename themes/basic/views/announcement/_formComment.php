
<li>
	<div class="avatar-container"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/avatar-img.png"></div>
		<?php
			$form=$this->beginWidget(
					'CActiveForm',
						array(
							'id' => 'comment_form',
							'enableAjaxValidation'=>false,
						)
			);
  ?>
	<div class="comment-container">
		<?php echo $form->textArea($model,'text',array('class' => "form-control"));  ?>
		<?php echo $form->hiddenField($model,'announcement_id',array('value' => $announcement->id));  ?>
		<?php echo $form->hiddenField($model,'id');  ?>
	</div>
	<div class="comment-button-container">
	<a id="comment_submit" class="btn btn-primary" href="#">
		Verstuur
	</a>
	</div>
		<?php $this->endWidget(); ?>
	</li>
<?php
Yii::app()->clientScript->registerScript('form submit','
	$("#comment_submit").click(function(){
		var data=$("#comment_form").serialize();
                $.ajax({
                        type: "POST",
                        url: "'.((isset($model->id) && !empty($model->id)) 
									? Yii::app()->createUrl("announcement/updateComment",array('id'=>$model->id)) 
									: Yii::app()->createUrl("announcement/saveComment")).'",
                        data:data,
                        success:function(data) {
                                $(".comment").html("");
								$(".comment").html(data);
                        },
                        error: function(data) { // if error occured
                                
                                 console.log(data);
                        },
                        dataType:"html"
                });
	
	});
');
 ?>