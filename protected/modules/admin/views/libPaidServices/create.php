<?php
/* @var $this LibPaidServicesController */
/* @var $model LibPaidServices */

$this->breadcrumbs=array(
	'Lib Paid Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibPaidServices', 'url'=>array('index')),
	array('label'=>'Manage LibPaidServices', 'url'=>array('admin')),
);
?>

<h1>Create LibPaidServices</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>