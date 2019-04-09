<?php
/* @var $this LibTypesController */
/* @var $model LibTypes */

$this->breadcrumbs=array(
	'Lib Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibTypes', 'url'=>array('index')),
	array('label'=>'Create LibTypes', 'url'=>array('create')),
	array('label'=>'Update LibTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibTypes', 'url'=>array('admin')),
);
?>

<h1>View LibTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
