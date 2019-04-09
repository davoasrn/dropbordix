<?php
/* @var $this LibFuelTypesController */
/* @var $model LibFuelTypes */

$this->breadcrumbs=array(
	'Lib Fuel Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibFuelTypes', 'url'=>array('index')),
	array('label'=>'Create LibFuelTypes', 'url'=>array('create')),
	array('label'=>'View LibFuelTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibFuelTypes', 'url'=>array('admin')),
);
?>

<h1>Update LibFuelTypes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>