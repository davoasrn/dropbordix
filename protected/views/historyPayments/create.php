<?php
/* @var $this HistoryPaymentsController */
/* @var $model HistoryPayments */

$this->breadcrumbs=array(
	'History Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HistoryPayments', 'url'=>array('index')),
	array('label'=>'Manage HistoryPayments', 'url'=>array('admin')),
);
?>

<h1>Create HistoryPayments</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>