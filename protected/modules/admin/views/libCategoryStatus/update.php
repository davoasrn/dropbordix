<?php
/* @var $this LibCategoryStatusController */
/* @var $model LibCategoryStatus */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibCategoryStatus', 'url'=>array('index')),
	array('label'=>'Create LibCategoryStatus', 'url'=>array('create')),
	array('label'=>'View LibCategoryStatus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibCategoryStatus', 'url'=>array('admin')),
);
?>

<h1>Update LibCategoryStatus <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>