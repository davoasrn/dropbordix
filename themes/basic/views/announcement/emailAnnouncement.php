<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <?php echo CHtml::link('&nbsp;','',array(
                    'class' => 'item-close-link',
                    'onclick' => 'navigationToView("'.Yii::app()->createUrl('announcement/view',array('id' => $model->id)).'");'
                    )); ?>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Email Dzez Adverteerder</h5>
                                <div class="success-register" style="font-size: 25px;color: #ff7921"></div>
                        </div>
                        <?php
                      
    $form1=$this->beginWidget('CActiveForm', array(
		'id'=>'announcement-email-form',
                'action' => Yii::app()->createUrl('announcement/checkEmail'),
		'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=> true,
                    'afterValidate' =>'js:function(form,data,hasError){
                        if(!hasError){
                            $.ajax({
                                "type" : "POST",
                                "url"  : "'.CHtml::normalizeUrl(array('announcement/emailAnnouncement','id' => $model->id)).'",
                                "data" : form.serialize(),
                                "success" : function(data) {
                                var json = JSON.parse(data);
                                if(json.status=="saved"){
                                    url = "'.Yii::app()->createUrl('announcement/view').'&id="+json.id
                                    navigationToView(url);
                                } 
                            }
                            });
                        }
                    }'
                )
    ));
  
    ?>
    <div class="form-group">	
   <?php echo $form1->labelEx($sendModel,'email'); ?>				
            <?php echo $form1->textField($sendModel,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control contact",'placeholder'=>"Emailadres...")); ?>
            <?php echo $form1->error($sendModel,'email'); ?>
    </div>
    <div class="form-group">					
            <?php echo $form1->textField($sendModel,'phone',array('size'=>20,'maxlength'=>18,'class'=>"form-control contact",'placeholder'=>"Telefoonnummer...")); ?>

            <span>Optioneel</span>
             <?php echo $form1->error($sendModel,'phone'); ?>
    </div>

    <div class="form-group">					


                    <?php echo $form1->dropDownList($sendModel,'role', 
                array(1=>'Bedrijven', 2=>'Particulier'),array('class'=>"form-control contact",'placeholder'=>"selecteren...")



                ); ?>
                   <?php echo $form1->error($sendModel,'role'); ?>
    </div>
    <div class="form-group">
        <?php    echo $form1->textArea($sendModel,'comments',array('size'=>200,'maxlength'=>888,'rows' => 6, 'cols' => 50,'class'=>"form-control contact",'placeholder'=>"Typ hier uw bericht...")); ?>
        <?php echo $form1->error($sendModel,'comments'); ?>
    </div>
    <span id="error-message"></span>
    <div class="form-group">
            <?php echo $form1->hiddenField($sendModel,'announcement_id',
                                       array('size'=>60,'maxlength'=>255,'class'=>"form-control",'value' => $model->id)); ?>
    </div>
    <br />
  
    <?php echo CHtml::tag('button', array('type'=>'submit', 'class'=>'btn btn-primary'),'stuur e-mail'); ?>
    
        <?php $this->endWidget(); ?>
        </div>
    
    </div>
</div>
