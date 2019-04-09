<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <a href="" class="item-close">&nbsp;</a>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Contact</h5>
                                Vragen en/of opmerkingen
                                <div class="success-register" style="font-size: 25px;color: #ff7921"></div>
                        </div>

                        
                        <?php
                      $action='site/validContact';
                      $url='site/contact';
         $form=$this->beginWidget('CActiveForm', array(
		         'id'=>'contactForm',
                'action' => Yii::app()->createUrl($action),
	            'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=> true,
                    'afterValidate' =>'js:function(form,data,hasError){
                        if(!hasError){
                            $.ajax({
                                "type" : "POST",
                                "url"  : "'.Yii::app()->createUrl($url).'",
                                "data" : form.serialize(),
                                "success" : function(data) {
                                var json = JSON.parse(data);
                                if(json.status=="saved"){
                                                    
                                    url = "'.Yii::app()->createUrl('site/contact').'",
                                    
                                    navigationToView(url);
                                    document.getElementById("contactForm").reset();  
                                } 
                            }
                            });
                        }
                    }'
                )
    )); ?>               <div class="form-group">	
                       <?php echo $form->labelEx($model,'email'); ?>				
                                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control contact",'placeholder'=>"Emailadres...")); ?>
                                <?php echo $form->error($model,'email'); ?>
                        </div>
                        <div class="form-group">					
                                <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>18,'class'=>"form-control contact",'placeholder'=>"Telefoonnummer...")); ?>
                                
                                <span>Optioneel</span>
                                 <?php echo $form->error($model,'phone'); ?>
                        </div>
                        
                        <div class="form-group">					
                               
                              
                            		<?php echo $form->dropDownList($model,'role', 
                                    array(1=>'Bedrijven', 2=>'Particulier'),array('class'=>"form-control contact",'placeholder'=>"selecteren...")
                                    
                                    
                                    
                                    ); ?>
    		                       <?php echo $form->error($model,'role'); ?>
                        </div>
                        <div class="form-group">
                         <?php    echo $form->textArea($model,'comments',array('size'=>200,'maxlength'=>888,'rows' => 6, 'cols' => 50,'class'=>"form-control contact",'placeholder'=>"Typ hier uw bericht...")); ?>
                        <?php echo $form->error($model,'comments'); ?>
                </div>
                        <span id="error-message"></span>
                <div class="edit-btn-wrapper">
                        <?php echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary'),'Versturen'); ?>
                    </div>
            <?php $this->endWidget(); ?>
                    
        </div>
        
          <div class="col-md-6 adv-photo-container">
                        <div class="edit-profile-title">
                                <h5>Contactgegevens</h5>
                                 Neem gerust contact met ons op
                        </div>
                       
                        
                        <?php 
                        /*
                         * Form for contact
                         * @register Contact model
                         */
                        $this->renderPartial('//site/_useContact',
                                    array(
                                        'model' => $model
                                    )
                                ); ?>
                      
                </div>
   
</div>
</div>