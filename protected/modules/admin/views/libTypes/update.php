<?php
/* @var $this LibTypesController */
/* @var $model LibTypes */

$this->breadcrumbs=array(
	'Lib Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibTypes', 'url'=>array('index')),
	array('label'=>'Create LibTypes', 'url'=>array('create')),
	array('label'=>'View LibTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibTypes', 'url'=>array('admin')),
);
?>

<h1>Update LibTypes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>