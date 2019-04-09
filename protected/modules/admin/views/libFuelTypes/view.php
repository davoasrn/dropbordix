<?php
/* @var $this LibFuelTypesController */
/* @var $model LibFuelTypes */

$this->breadcrumbs=array(
	'Lib Fuel Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibFuelTypes', 'url'=>array('index')),
	array('label'=>'Create LibFuelTypes', 'url'=>array('create')),
	array('label'=>'Update LibFuelTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibFuelTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibFuelTypes', 'url'=>array('admin')),
);
?>

<h1>View LibFuelTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
