<?php
/* @var $this LibCategoryStatusController */
/* @var $model LibCategoryStatus */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LibCategoryStatus', 'url'=>array('index')),
	array('label'=>'Create LibCategoryStatus', 'url'=>array('create')),
	array('label'=>'Update LibCategoryStatus', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibCategoryStatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibCategoryStatus', 'url'=>array('admin')),
);
?>

<h1>View LibCategoryStatus #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
