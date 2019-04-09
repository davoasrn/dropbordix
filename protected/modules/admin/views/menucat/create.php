<?php
/* @var $this MenuCatController */
/* @var $model MenuCat */

$this->breadcrumbs=array(
	'Menu Cats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MenuCat', 'url'=>array('index')),
	array('label'=>'Manage MenuCat', 'url'=>array('admin')),
);
?>

<h1>Create MenuCat</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>