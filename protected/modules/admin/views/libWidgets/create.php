<?php
/* @var $this LibWidgetsController */
/* @var $model LibWidgets */

$this->breadcrumbs=array(
	'Lib Widgets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibWidgets', 'url'=>array('index')),
	array('label'=>'Manage LibWidgets', 'url'=>array('admin')),
);
?>

<h1>Create LibWidgets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>