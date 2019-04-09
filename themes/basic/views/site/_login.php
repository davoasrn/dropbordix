<div class="home-sidebar-item sidebar-item">
<div class="home-item-title">
        <h2>GEBRUIKER</h2>
        <a href="" class="item-close">&nbsp;</a>
</div>
<div class="sidebar-item-body sidebar-login-container">
        <h5>LOGIN VOOR OPTIMAAL GEBRUIK</h5>
        <div class="login-form-wrapper">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableAjaxValidation'=>false,
            )); ?>    
                        <div class="form-group">					
                                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"home-input form-control",'placeholder'=>"gebruikersnaam...")); ?>
                                <?php echo $form->error($model,'email'); ?>
                        </div>
                        <div class="form-group">					
                                <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255,'class'=>"home-input form-control",'placeholder'=>"wachtwoord...")); ?>
                        </div>
                        <span id="error-message"></span>
                
            <?php $this->endWidget(); ?>
                    <div class="login-btn-container">
                        <?php echo CHtml::ajaxLink('login',array('site/login'),
                                array(
                                    'type' => 'POST',
                                    'data' => 'js:$("#login-form").serialize()',
                                    'success' => 'js:function(data){
                                        var json = JSON.parse(data);
                                        if(json.status == "success")
                                            location.reload();
                                        else{
                                            $("#error-message").text("");
                                            $("#error-message").text("Incorrect email or password");
                                        }
                                    }'
                                ),
                                array('class' => "btn btn-login")); ?>
                    </div>
        </div>
        <div class="question"><a href=""> wachtwoord of gebruikersnaam vergeten? klik hier</a></div>				
        <div class="new-user-buttons">
                <p>Nieuwe gebruiker?</p>
                <div>
                    <!--    
                    <a href="loginFb.php?provider=facebook" class="btn btn-signin fb-btn">
                                <i class="fa fa-facebook-square"></i>
                                LOGIN MET 
                                FACEBOOK
                        </a> -->
                    <?php
//                    echo CHtml::link('<i class="fa fa-facebook-square"></i>
//                                LOGIN MET FACEBOOK',
//                                array('site/loginFb','provider' => 'facebook'),
//                                array('class' =>'btn btn-signin fb-btn','target' => '_blank')); 
                    ?>
                    <?php echo CHtml::link('<i class="fa fa-facebook-square"></i>
                                LOGIN MET FACEBOOK',
                                array(),
                                array(
                                    'class' =>'btn btn-signin fb-btn',
                                    'onclick' => '$(".services .auth-services .facebook .auth-link").click()'
                                    )); ?>
                        <span>or</span>
                        <a href="#" class="btn btn-signin" onclick="js:navigation(this)" data-href="<?php echo Yii::app()->createUrl('site/login') ?>">
                                REGISTREER
                        </a>
                </div>
        </div>
</div>
</div>