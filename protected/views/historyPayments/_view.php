<?php
/* @var $this HistoryPaymentsController */
/* @var $data HistoryPayments */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('history_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->history_id), array('view', 'id'=>$data->history_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('announcement_id')); ?>:</b>
	<?php echo CHtml::encode($data->announcement_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sum')); ?>:</b>
	<?php echo CHtml::encode($data->sum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('change_date')); ?>:</b>
	<?php echo CHtml::encode($data->change_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('insert_date')); ?>:</b>
	<?php echo CHtml::encode($data->insert_date); ?>
	<br />

	*/ ?>

</div>