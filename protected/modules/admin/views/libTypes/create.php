<?php
/* @var $this LibTypesController */
/* @var $model LibTypes */

$this->breadcrumbs=array(
	'Lib Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibTypes', 'url'=>array('index')),
	array('label'=>'Manage LibTypes', 'url'=>array('admin')),
);
?>

<h1>Create LibTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>