<?php
/* @var $this LibCategoryStatusController */
/* @var $model LibCategoryStatus */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibCategoryStatus', 'url'=>array('index')),
	array('label'=>'Manage LibCategoryStatus', 'url'=>array('admin')),
);
?>

<h1>Create LibCategoryStatus</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>