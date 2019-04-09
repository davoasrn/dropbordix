<div class="edit-profile-form-container">
    <?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form-popup',
        'action' => Yii::app()->createUrl('users/checkLogin'),
	'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=> true,
            'afterValidate' =>'js:function(form,data,hasError){
                if(!hasError){
                    $.ajax({
                        "type" : "POST",
                        "url"  : "'.CHtml::normalizeUrl(array("site/login")).'",
                        "data" : $("#login-form-popup").serialize(),
                        "success" : function(data) {
                        var json = JSON.parse(data);
                        if(json.status=="success"){
//                            $.each(data, function(key, val) {
//                               $("#login-form #"+key+"_em_").text("");                                                    
//                            });
                            location.reload();
                           //document.getElementById("register-form").reset();
                        }else{
                             $.each(data, function(key, val) {
                             $("#login-form #"+key+"_em_").text("");                                                    
                            });
                        }
                    }
                    });
                }
            }'
        )
    ));

 


    ?>    
        <div class="form-group">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Emailadres..")); ?>
                <?php echo $form->error($model,'email'); ?>
        </div>
        <div class="form-group">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Wachtwoord...")); ?>
                <?php echo $form->error($model,'password'); ?>

        </div>
        <div id = 'error-message'></div>
        <div class="edit-btn-wrapper login-page-btn-wrapper">
                <?php
                   echo CHtml::htmlButton('Bevestig', array(
                       'type'=>'submit', 
                       'class'=>'bnt btn-primary',
//                       'ajax' => array(
//                                    'type' => 'POST',
//                                    'data' => 'js:$("#login-form").serialize()',
//                                    'success' => 'js:function(data){
//                                        var json = JSON.parse(data);
//                                        if(json.status == "success")
//                                            location.reload();
//                                        else{
//                                            $("#error-message").text("");
//                                            $("#error-message").text("Incorrect login or username");
//                                        }
//                                    }'
//                                ),
                       
                       ));
                ?>
                Bent uw uw gebruikersnaam of wachtwoord vergeten? <br>
                Klik dan hier
        </div>
    <?php $this->endWidget(); ?>
    
</div>

        