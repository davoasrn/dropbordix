<?php
/* @var $this LibWidgetsController */
/* @var $model LibWidgets */

$this->breadcrumbs=array(
	'Lib Widgets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibWidgets', 'url'=>array('index')),
	array('label'=>'Create LibWidgets', 'url'=>array('create')),
	array('label'=>'Update LibWidgets', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibWidgets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibWidgets', 'url'=>array('admin')),
);
?>

<h1>View LibWidgets #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
	),
)); ?>
