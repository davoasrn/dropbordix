<?php
/* @var $this LibOmnikassaController */
/* @var $model LibOmnikassa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lib-omnikassa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'merchant_id'); ?>
		<?php echo $form->textField($model,'merchant_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'merchant_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'security_key'); ?>
		<?php echo $form->textField($model,'security_key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'security_key'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'security_key_version'); ?>
		<?php echo $form->textField($model,'security_key_version',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'security_key_version'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'video_price'); ?>
		<?php echo $form->textField($model,'video_price',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'video_price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'site_url_price'); ?>
		<?php echo $form->textField($model,'site_url_price',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'site_url_price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status',array(0=>'disable', 1=>'enable')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->