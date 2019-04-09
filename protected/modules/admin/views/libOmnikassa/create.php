<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Lib Omnikassa'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List LibOmnikassa', 'url'=>array('index')),
//	array('label'=>'Manage LibOmnikassa', 'url'=>array('admin')),
);
?>

<h1>Create LibOmnikassa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>