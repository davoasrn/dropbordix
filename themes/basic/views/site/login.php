<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <a href="" class="item-close">&nbsp;</a>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Registreren</h5>
                                Heeft u nog geen account?
                                <div class="success-register" style="font-size: 25px;color: #ff7921"></div>
                        </div>
                        <?php 
                        /*
                         * Form for registration
                         * @register Users model
                         * @action action form form
                         * @url url for ajax 
                         */
                        $this->renderPartial('//users/_formRegister',
                                array(
                                    'model' => $register,
                                    'action' => 'users/checkRegister',
                                    'url' => array("users/create")
                                )); ?>
                    
                        
                </div>


                <div class="col-md-6 adv-photo-container">
                        <div class="edit-profile-title">
                                <h5>Inloggen</h5>
                                Inloggen met bestaand account
                        </div>
                        <?php 
                        /*
                         * Form for registration
                         * @register Users model
                         */
                        $this->renderPartial('//users/_formLogin',
                                    array(
                                        'model' => $model
                                    )
                                ); ?>
                        <div class="edit-profile-title">
                                <h5>Inloggen met facebook</h5>
                                Gebruik uw Facebook account om in te loggen
                        </div>
                        <p>Klik op de knop hieronder om in te loggen met uw Facebook account.</p>
                        <div class="edit-btn-wrapper login-page-btn-wrapper">
                            <?php                            
                                echo CHtml::tag('button', array('onclick' => '$(".services .auth-services .facebook .auth-link").click()', 'class'=>'bnt btn-primary'),'Bevestig');
                            ?>

                        </div>
                </div>
        </div>
</div>
