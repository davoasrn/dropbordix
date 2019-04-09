<?php
$model = new Payments;
if(isset($announcement->user) && isset($announcement->user->postalCode) 
        && !empty($announcement->user->postalCode->latitude) && !empty($announcement->user->postalCode->longitude)){
            $latitude = $announcement->user->postalCode->latitude;
            $longitude = $announcement->user->postalCode->longitude;
        }
    
?>
<div class="bieden-wrapper">
    <p>
        <?php 
        if(isset($latitude) && isset($longitude))
            echo CHtml::link('Bekijk op Google maps', 'https://www.google.com.au/maps/preview/@'.$latitude.','.$longitude.',12z',array('target'=>'_blank'));
        ?>
    </p>
        <div class="adv-bieden-container">
                <div class="bieden-title">
                        <h4>BIEDEN</h4>
                        <!-- Slide THREE -->

                </div>
                <div class="bieden-content">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'payment-create-form',
                                'enableAjaxValidation'=>false,
                            )); 
                    ?>
                        <div class="form-group">
                                <?php echo $form->textField($model,'email',array('placeholder'=>"E-mail adres..",'class'=>"form-control")); ?>
                                <?php echo $form->error($model,'email'); ?>
                        </div>
                        <div class="form-group">
                                <?php echo $form->textField($model,'sum',array('placeholder'=>"€",'class'=>"form-control")); ?>
                                <?php echo $form->error($model,'sum'); ?>
                        </div>
                        <div class="form-group">
                                <?php echo $form->hiddenField($model,'announcement_id',array('value' => $announcement->id)); ?>
                        </div>
                        <?php $this->endWidget(); ?>
                        <div class="form-group">
                                <?php
                                    echo CHtml::tag('button', array(
                                        'class'=>'bnt btn-primary',
                                        'id' =>'payment_submit',
                                        'onclick' => '
                                            js:paymentSubmit("'.Yii::app()->createUrl('payments/create').'","payment-create-form","bieden-list");
                                        ',
                                        ),'Plaats uw bod');
                               
                                ?>
                        </div>
                   
                </div>
                <?php 
                $this->renderPartial('//payments/view',array('payments' => $payments));
                ?>
        </div>
</div>
