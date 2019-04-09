<?php
/* @var $this HistoryPaymentsController */
/* @var $model HistoryPayments */

$this->breadcrumbs=array(
	'History Payments'=>array('index'),
	$model->history_id=>array('view','id'=>$model->history_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HistoryPayments', 'url'=>array('index')),
	array('label'=>'Create HistoryPayments', 'url'=>array('create')),
	array('label'=>'View HistoryPayments', 'url'=>array('view', 'id'=>$model->history_id)),
	array('label'=>'Manage HistoryPayments', 'url'=>array('admin')),
);
?>

<h1>Update HistoryPayments <?php echo $model->history_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>