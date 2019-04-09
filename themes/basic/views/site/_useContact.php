                         <b>Dropbord.nl</b>
                        <br/><br/> 
                        <b>Berkenstraat 3B</b><br/>
                        <b>8924BW Leeuwarden</b><br/>
                        <b>Nederland</b>                        
                        <br /><br/> 
                        <b>T: 06 111 421 25</b><br/>
                        <b>T: 06 199 570 67</b>
                        <br /><br/> 
                        <b>E: bedrijven@dropbord.nl</b><br/>
                        <b>E: particulier@dropbord.nl</b>
                        <br /><br/>
                          <div class="edit-profile-title">
                                <h5>Email verloren ?</h5>
                                 Bewerkingsmail opvragen
                        </div>
                        
                        <b>
                        Bent u uw  email voor het  bewerken van uw adwedentie
                        verloren? Vul hieronder uw mail in en vraag een nieuwe
                        bewerkingsmail aan.
                        
                        </b>
      
                            
                             <?php
                     $action='site/validContact';
                      $url='site/useContact';
         $form=$this->beginWidget('CActiveForm', array(
		'id'=>'useContactForm',
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
                                    location.reload();
//                                    url = "'.Yii::app()->createUrl('site/useContact').'",
//                                    navigationToView(url);
//                                    document.getElementById("useContactForm").reset();  
                                } 
                                else if(json.status=="isnull")
                                {
                                   document.getElementById("message").innerHTML  = "Opgegeven e-mail adres niet gevonden";
                                   document.getElementById("message").style.color  = "#FF0040";
                                }
                            }
                            });
                        }
                    }'
                )
    )); ?>
                         <div id="message">&nbsp;</div>
                        <div class="form-group" >
                       
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'Email ...')); ?>
                        <?php echo $form->error($model,'email'); ?>
                             </div>
                        <div class="edit-btn-wrapper login-page-btn-wrapper">
                                
                                <?php echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary'),'Aanvragen'); ?>
                                
                        </div>
                            <?php $this->endWidget(); ?>
           