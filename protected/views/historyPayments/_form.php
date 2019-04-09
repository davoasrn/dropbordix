<?php
/* @var $this HistoryPaymentsController */
/* @var $model HistoryPayments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'history-payments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'announcement_id'); ?>
		<?php echo $form->textField($model,'announcement_id'); ?>
		<?php echo $form->error($model,'announcement_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sum'); ?>
		<?php echo $form->textField($model,'sum',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?>
		<?php echo $form->error($model,'add_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'change_date'); ?>
		<?php echo $form->textField($model,'change_date'); ?>
		<?php echo $form->error($model,'change_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insert_date'); ?>
		<?php echo $form->textField($model,'insert_date'); ?>
		<?php echo $form->error($model,'insert_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->