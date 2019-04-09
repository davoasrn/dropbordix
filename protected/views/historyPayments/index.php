<?php
/* @var $this HistoryPaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'History Payments',
);

$this->menu=array(
	array('label'=>'Create HistoryPayments', 'url'=>array('create')),
	array('label'=>'Manage HistoryPayments', 'url'=>array('admin')),
);
?>

<h1>History Payments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
