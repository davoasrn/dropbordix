<?php
/* @var $this AutoDetailController */
/* @var $model AutoDetail */

$this->breadcrumbs=array(
	'Auto Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AutoDetail', 'url'=>array('index')),
	array('label'=>'Create AutoDetail', 'url'=>array('create')),
	array('label'=>'Update AutoDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AutoDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AutoDetail', 'url'=>array('admin')),
);
?>

<h1>View AutoDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'announcement_id',
		'seats',
		'year',
		'mileage',
		'transmission_id',
		'fuel_id',
	),
)); ?>
