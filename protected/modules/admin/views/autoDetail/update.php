<?php
/* @var $this AutoDetailController */
/* @var $model AutoDetail */

$this->breadcrumbs=array(
	'Auto Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AutoDetail', 'url'=>array('index')),
	array('label'=>'Create AutoDetail', 'url'=>array('create')),
	array('label'=>'View AutoDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AutoDetail', 'url'=>array('admin')),
);
?>

<h1>Update AutoDetail <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>