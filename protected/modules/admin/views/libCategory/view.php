<?php
/* @var $this libCategoryController */
/* @var $model libCategory */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List libCategory', 'url'=>array('index')),
	array('label'=>'Create libCategory', 'url'=>array('create')),
	array('label'=>'Update libCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete libCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage libCategory', 'url'=>array('admin')),
);
?>

<h1>View libCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
                array(
                    'name' => 'parent_id',
                    'value' => isset($model->parent) ? $model->parent->name : "",
                    'visible' => isset($model->parent) ? true : false
                )
	),
)); ?>
