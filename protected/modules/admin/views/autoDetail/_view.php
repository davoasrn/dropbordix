<?php
/* @var $this AutoDetailController */
/* @var $data AutoDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('announcement_id')); ?>:</b>
	<?php echo CHtml::encode($data->announcement_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seats')); ?>:</b>
	<?php echo CHtml::encode($data->seats); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mileage')); ?>:</b>
	<?php echo CHtml::encode($data->mileage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transmission_id')); ?>:</b>
	<?php echo CHtml::encode($data->transmission_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuel_id')); ?>:</b>
	<?php echo CHtml::encode($data->fuel_id); ?>
	<br />


</div>