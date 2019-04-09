<?php
/* @var $this AutoDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auto Details',
);

$this->menu=array(
	array('label'=>'Create AutoDetail', 'url'=>array('create')),
	array('label'=>'Manage AutoDetail', 'url'=>array('admin')),
);
?>

<h1>Auto Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
