<?php if(!isset($not_logined)){ ?>
<div class="edit-profile-form-container">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
        'action' => Yii::app()->createUrl('users/checkRegister'),
	'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=> true,
            'afterValidate' =>'js:function(form,data,hasError){
                if(!hasError){
                    $.ajax({
                        "type" : "POST",
                        "url"  : "'.CHtml::normalizeUrl(array("users/create")).'",
                        "data" : form.serialize(),
                        "success" : function(data) {
                        var json = JSON.parse(data);
                        if(json.status=="saved"){
                            $.each(data, function(key, val) {
                               $("#register-form #"+key+"_em_").text("");                                                    
                            });
                            //location.reload();
                            document.getElementById("register-form").reset();
                        } 
                    }
                    });
                }
            }'
        )
    )); 
}
    ?>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>"form-control register")); ?>
                        <?php echo $form->error($model,'name'); ?>
                </div>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control register")); ?>
                        <?php echo $form->error($model,'email'); ?>
                </div>
                <div class="form-group postcode-wrapper">
                        <?php echo $form->labelEx($model,'postal_code'); ?>
                        <?php echo $form->textField($model,'postal_code',array('placeholder'=>"0000",'class'=>"form-control register",'maxlength'=>4)); ?>
                        <?php echo $form->textField($model,'postal_code_letter',array('maxlength'=>2,'class'=>"form-control register",'placeholder'=>"AB")); ?>
                        <?php echo $form->error($model,'postal_code'); ?>
<!--                        <span>*</span> -->
                </div>
    <?php if(!isset($not_logined)){ ?>
                <div class="form-group tel-number">
                        <?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255,'class'=>"form-control register")); ?>
                        <span>Optioneel</span>
                </div>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'password'); ?>
                        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>"form-control register",'placeholder'=>"Wachtwoord...")); ?>
                        <?php echo $form->error($model,'password'); ?>
                </div>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'repeat_password'); ?>
                        <?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>255,'class'=>"form-control register",'placeholder'=>"Wachtwoord...")); ?>
                        <?php echo $form->error($model,'repeat_password'); ?>
                </div>
                <div class="edit-btn-wrapper">
                        <?php
                            echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary'),'Bevestig');
                        ?>

                </div>
       <?php $this->endWidget(); ?>
</div>
    <?php } ?>