<?php
/* @var $this MenuCatController */
/* @var $model MenuCat */

$this->breadcrumbs=array(
	'Menu Cats'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MenuCat', 'url'=>array('index')),
	array('label'=>'Create MenuCat', 'url'=>array('create')),
	array('label'=>'Update MenuCat', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenuCat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MenuCat', 'url'=>array('admin')),
);
?>

<h1>View MenuCat #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cat_name',
	),
)); ?>
