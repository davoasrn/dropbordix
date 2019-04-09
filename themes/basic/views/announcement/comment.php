<?php
if(!is_null(Yii::app()->user->getState('type')) && Yii::app()->user->getState('type') == 3)
    $photo = Yii::app()->user->getState('photo') ;
elseif (!is_null(Yii::app()->user->getState('photo')) && Yii::app()->user->getState('photo') != "") {
    $photo = '/images/'.Yii::app()->user->getId()."/".Yii::app()->user->getState('photo');
}  else {
    $photo = Yii::app()->theme->baseUrl.'/img/user-img.png';
}
?>
<div class="direct-row comment">
    <ul>
	<?php foreach($comments as $comment){ 
            if(!is_null($comment->user->type) && $comment->user->type == 3)
                $photoComment = $comment->user->photo ;
            elseif (!is_null($comment->user->photo) && $comment->user->photo != "") {
                $photoComment = '/images/'.$comment->user->id."/".$comment->user->photo;
            }  else {
                $photoComment = Yii::app()->theme->baseUrl.'/img/user-img.png';
            }
            ?>
        <li>
                <div class="avatar-container"><img src="<?php echo $photoComment; ?>"></div>
                <div>
                        <span>Reactie geplaatst door 
                        <?php 
                        setlocale(LC_TIME, 'NL_nl');
                        echo $comment->user->name
                        ." op ".
                        strftime('%d-%m-%Y om %H:%M',strtotime($comment->add_date))
                        .' uur'
                        ; ?>
                        </span>
                        <br><?php echo $comment->text; ?> 
                </div>
                <div class="icons-container">
                        <?php 
                                $imgEdit = CHtml::image(Yii::app()->theme->baseUrl.'/img/pen.png', 'edit');
                                $imgDel = CHtml::image(Yii::app()->theme->baseUrl.'/img/bin.png', 'remove');

                                if($comment->user_id == Yii::app()->user->getId()){
                                        //update link
                                        echo CHtml::link($imgEdit,'#',
                                                                        array(
                                                                                        'onclick' => 'js:edit(this)',
                                                                                        'data-id'=>$comment->id,
                                                                                        'data-text' =>$comment->text,
                                                                                        "id" => 'edit_comment'
                                                                                )
                                                                );
                                        //delete link	
                                        echo CHtml::link($imgDel,'#',
                                                                        array(
                                                                                        'onclick' => 'js:del(this)',
                                                                                        'data-id'=>$comment->id,
                                                                                        "id" => 'delete_comment'
                                                                                )
                                                                );	
                                }

                        ?>

                </div>
                <div class="flag-text">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/flag.png"><br>
                        <span>Meldt dit bericht</span>
                </div>
        </li>
	<?php } ?>
							
	<?php if(!is_null(Yii::app()->user->getId())){ ?>						
        <li>
            <div class="avatar-container"><img src="<?php echo $photo; ?>"></div>
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
        <?php }else{
			echo "<li><span style='color: #666;margin:5px;'>Klik INLOGGEN om in te loggen.</span>";
            echo CHtml::tag('button', array(
                                'type'=>'submit', 
                                'class'=>'btn btn-primary',
                                'data-href'=>Yii::app()->createUrl('site/login') ,
                                'onclick' => 'js:navigation(this)'
                                ),'INLOGGEN');
								
			echo "</li>";
            } ?>
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
							
<?php
Yii::app()->clientScript->registerScript('edit-delete','
	function edit(e){
		var id = $(e).data("id");
		var text = $(e).data("text");
		$("#Comments_text").val(text);
		$("#Comments_id").val(id);
		$("#Comments_text").focus();
	};
	
	function del(e){
		var id = $(e).data("id");
		var data = {id:id};
		$.ajax({
                        type: "POST",
                        url: "'.Yii::app()->createUrl("announcement/deleteComment").'",
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
	};
',CClientScript::POS_END);
 ?>
							

						</ul>
					</div>