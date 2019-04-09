<?php
/* @var $this LibFuelTypesController */
/* @var $model LibFuelTypes */

$this->breadcrumbs=array(
	'Lib Fuel Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibFuelTypes', 'url'=>array('index')),
	array('label'=>'Manage LibFuelTypes', 'url'=>array('admin')),
);
?>

<h1>Create LibFuelTypes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>