<?php
/* @var $this AutoDetailController */
/* @var $model AutoDetail */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'announcement_id'); ?>
		<?php echo $form->textField($model,'announcement_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seats'); ?>
		<?php echo $form->textField($model,'seats'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'year'); ?>
		<?php echo $form->textField($model,'year',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mileage'); ?>
		<?php echo $form->textField($model,'mileage',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transmission_id'); ?>
		<?php echo $form->textField($model,'transmission_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fuel_id'); ?>
		<?php echo $form->textField($model,'fuel_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->