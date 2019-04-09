<?php
/* @var $this LibPaidServicesController */
/* @var $model LibPaidServices */

$this->breadcrumbs=array(
	'Lib Paid Services'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibPaidServices', 'url'=>array('index')),
	array('label'=>'Create LibPaidServices', 'url'=>array('create')),
	array('label'=>'Update LibPaidServices', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibPaidServices', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibPaidServices', 'url'=>array('admin')),
);
?>

<h1>View LibPaidServices #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'price',
	),
)); ?>
