<?php
/* @var $this LibPostsController */
/* @var $model LibPosts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lib-posts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'country_code'); ?>
		<?php echo $form->textField($model,'country_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postal_code'); ?>
		<?php echo $form->textField($model,'postal_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'postal_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'place_name'); ?>
		<?php echo $form->textField($model,'place_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'place_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_code'); ?>
		<?php echo $form->textField($model,'state_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'state_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'province'); ?>
		<?php echo $form->textField($model,'province',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'province'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'province_code'); ?>
		<?php echo $form->textField($model,'province_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'province_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'community'); ?>
		<?php echo $form->textField($model,'community',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'community'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'communit_code'); ?>
		<?php echo $form->textField($model,'communit_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'communit_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latitude'); ?>
		<?php echo $form->textField($model,'latitude',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'latitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longitude'); ?>
		<?php echo $form->textField($model,'longitude',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lat_lag'); ?>
		<?php echo $form->textField($model,'lat_lag',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lat_lag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->