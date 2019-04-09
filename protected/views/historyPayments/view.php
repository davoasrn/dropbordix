<?php
/* @var $this HistoryPaymentsController */
/* @var $model HistoryPayments */

$this->breadcrumbs=array(
	'History Payments'=>array('index'),
	$model->history_id,
);

$this->menu=array(
	array('label'=>'List HistoryPayments', 'url'=>array('index')),
	array('label'=>'Create HistoryPayments', 'url'=>array('create')),
	array('label'=>'Update HistoryPayments', 'url'=>array('update', 'id'=>$model->history_id)),
	array('label'=>'Delete HistoryPayments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->history_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HistoryPayments', 'url'=>array('admin')),
);
?>

<h1>View HistoryPayments #<?php echo $model->history_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'history_id',
		'id',
		'announcement_id',
		'sum',
		'email',
		'add_date',
		'change_date',
		'insert_date',
	),
)); ?>
