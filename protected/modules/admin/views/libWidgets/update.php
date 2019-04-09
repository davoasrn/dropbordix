<?php
/* @var $this LibWidgetsController */
/* @var $model LibWidgets */

$this->breadcrumbs=array(
	'Lib Widgets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibWidgets', 'url'=>array('index')),
	array('label'=>'Create LibWidgets', 'url'=>array('create')),
	array('label'=>'View LibWidgets', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibWidgets', 'url'=>array('admin')),
);
?>

<h1>Update LibWidgets <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>