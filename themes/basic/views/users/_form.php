<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <a href="#" class="item-close">&nbsp;</a>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Profiel bewerken</h5>
                                Bewerk uw gegevens
                        </div>
                            <?php  
                            /*
                             * user registration page
                             * @model Users model
                             * @updae_person do not show save button in this page
                             */
                            $this->renderPartial('_formRegister',array(
                                'model' => $model,
                                'action' => 'users/checkRegister',
                                'url' => array("users/update",'id'=>Yii::app()->user->getId()),
                                'update_person' => 1,
                                )); 
                            ?>
                        
                </div>


                <div class="col-md-6 adv-photo-container">
                        <div class="edit-profile-title">
                                <h5>Bewerk uw foto</h5>
                                Upload een nieuwe foto
                        </div>
                        <div class="upload-photo">
                                <div class="user-img-wrapper">
                                     <?php 
                                    if(!is_null(Yii::app()->user->getState('type')) && Yii::app()->user->getState('type') == 3)
                                        $photo = Yii::app()->user->getState('photo') ;
                                    elseif (!is_null(Yii::app()->user->getState('photo')) && Yii::app()->user->getState('photo') != "") {
                                        $photo = '/images/'.Yii::app()->user->getId()."/".Yii::app()->user->getState('photo');
                                    }  else {
                                        $photo = Yii::app()->theme->baseUrl.'/img/user-img.png';
                                    }

                                    ?>
                                        <img style="width:100px;height:100px" src="<?php echo $photo; ?>">
                                </div>
                                <?php
                                    echo CHtml::tag('button',
                                                        array(
                                                                        'class'=>'btn btn-primary',
                                                                        'onclick' => 'document.getElementById("Users_photo").click(); return false'
                                                                ),'Upload');
        ?>
                            <?php 
                                if(!is_null(Yii::app()->user->getId())){
                                    //echo CHtml::tag('button', array('onclick' => 'js:document.location.href="index.php?r=site/logout','type'=>'submit', 'class'=>'bnt btn-primary'), 'UITLOGEN');
                                    echo CHtml::button('UITLOGGEN', array('submit' => array('site/logout'),'class' =>'btn btn-primary')); 
                                }
                            ?>

                        </div>
                </div>
        </div>
</div>
