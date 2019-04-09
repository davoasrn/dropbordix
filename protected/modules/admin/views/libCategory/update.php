<?php
/* @var $this libCategoryController */
/* @var $model libCategory */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List libCategory', 'url'=>array('index')),
	array('label'=>'Create libCategory', 'url'=>array('create')),
	array('label'=>'View libCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage libCategory', 'url'=>array('admin')),
);
?>

<h1>Update libCategory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>