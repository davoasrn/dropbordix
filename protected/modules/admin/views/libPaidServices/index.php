<?php
/* @var $this LibPaidServicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Paid Services',
);

$this->menu=array(
	array('label'=>'Create LibPaidServices', 'url'=>array('create')),
	array('label'=>'Manage LibPaidServices', 'url'=>array('admin')),
);
?>

<h1>Lib Paid Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
