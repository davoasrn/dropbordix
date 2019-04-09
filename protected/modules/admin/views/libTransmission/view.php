<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Lib Transmissions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibTransmission', 'url'=>array('index')),
	array('label'=>'Create LibTransmission', 'url'=>array('create')),
	array('label'=>'Update LibTransmission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibTransmission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>View LibTransmission #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
