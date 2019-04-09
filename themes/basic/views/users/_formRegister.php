<?php if(!isset($not_logined)){ ?>
<div class="edit-profile-form-container">
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
        'action' => CHtml::normalizeUrl($url),
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true, // Required to perform AJAX validation on form submit
            //'afterValidate'=>'js:mySubmitFormFunction', // Your JS function to submit form
        //    'afterValidate'=>'$("#register-form").submit();', // Your JS function to submit form
        ),
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
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
                
                <div class="form-group">
                        <?php $model->password = null; ?>
                        <?php echo $form->labelEx($model,'password'); ?>
                        <?php echo $form->passwordField($model,'password',array('value' =>'','size'=>60,'maxlength'=>255,'class'=>"form-control register",'placeholder'=>"Wachtwoord...")); ?>
                        <?php echo $form->error($model,'password'); ?>
                </div>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'repeat_password'); ?>
                        <?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>255,'class'=>"form-control register",'placeholder'=>"Wachtwoord...")); ?>
                        <?php echo $form->error($model,'repeat_password'); ?>
                </div>
                <div class="form-group tel-number">
                        <?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255,'class'=>"form-control register")); ?>
                        <span>Optioneel</span>
                </div>
				
		<div class="form-group" style="display:none">
                        <?php   echo $form->fileField($model, 'photo', array('disabled'=>!$model->isAttributeSafe('photo'))); ?>
                        
                </div>
                
                <?php if(isset($update_person)){ ?>
                        <div class="edit-btn-wrapper">
                <?php } ?>
                                <div class="edit-btn-wrapper">
                                        <?php
                                            echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary'),isset($update_person) ? 'Opslaan' : 'Bevestig');
                                        ?>
                                        
                                </div>
                <?php if(isset($update_person)){ ?>
                                <span>Wijzigingen opslaan</span>
                        </div>
                <?php } ?>
       <?php $this->endWidget(); ?>
</div>
    <?php } ?>
