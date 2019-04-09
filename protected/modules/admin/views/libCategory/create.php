<?php
/* @var $this libCategoryController */
/* @var $model libCategory */

$this->breadcrumbs=array(
	'Lib Category Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List libCategory', 'url'=>array('index')),
	array('label'=>'Manage libCategory', 'url'=>array('admin')),
);
?>

<h1>Create libCategory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>