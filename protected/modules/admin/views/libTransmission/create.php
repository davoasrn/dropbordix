<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Lib Transmissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibTransmission', 'url'=>array('index')),
	array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>Create LibTransmission</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>