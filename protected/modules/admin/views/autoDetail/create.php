<?php
/* @var $this AutoDetailController */
/* @var $model AutoDetail */

$this->breadcrumbs=array(
	'Auto Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AutoDetail', 'url'=>array('index')),
	array('label'=>'Manage AutoDetail', 'url'=>array('admin')),
);
?>

<h1>Create AutoDetail</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>