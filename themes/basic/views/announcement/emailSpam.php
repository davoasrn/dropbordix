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
                                <h5>Wij zoeken voor u</h5>
                                word op de hoogte gebracht van nieuwe advertenties
                                <div class="success-register" style="font-size: 25px;color: #ff7921"></div>
                        </div>
                        <?php

    $form1=$this->beginWidget('CActiveForm', array(
		'id'=>'announcement-spam-form',
                'action' => Yii::app()->createUrl('announcement/checkEmailSpam'),
		'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=> true,
                    'afterValidate' =>'js:function(form,data,hasError){
                        if(!hasError){
                            $.ajax({
                                "type" : "POST",
                                "url"  : "'.CHtml::normalizeUrl(array('announcement/emailSpam','id' => $model->id)).'",
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
            <?php echo $form1->labelEx($sendModel,'name'); ?>
            <?php echo $form1->textField($sendModel,'name',
                                       array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Your name")); ?>
            <?php echo $form1->error($sendModel,'name'); ?>
    </div>
    <div class="form-group">
            <?php echo $form1->labelEx($sendModel,'emailFrom'); ?>
            <?php echo $form1->textField($sendModel,'emailFrom',
                                       array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Email from")); ?>
            <?php echo $form1->error($sendModel,'emailFrom'); ?>
    </div>
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
