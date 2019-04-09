<?php
/* @var $this AutoDetailController */
/* @var $model AutoDetail */
/* @var $form CActiveForm */
?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'seats'); ?>
		<?php echo $form->textField($model,'seats'); ?>
		<?php echo $form->error($model,'seats'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mileage'); ?>
		<?php echo $form->textField($model,'mileage',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'mileage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transmission_id'); ?>
		<?php echo $form->dropDownList($model,'transmission_id',CHtml::listData(LibTransmission::model()->findAll(),'id','name'),array('empty' => 'Select a name')); ?>
		<?php echo $form->error($model,'transmission_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fuel_id'); ?>
		<?php echo $form->dropDownList($model,'fuel_id',CHtml::listData(LibFuelTypes::model()->findAll(),'id','name'),array('empty' => 'Select a name')); ?>
		<?php echo $form->error($model,'fuel_id'); ?>
	</div>