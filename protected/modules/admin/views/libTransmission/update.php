<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Lib Transmissions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibTransmission', 'url'=>array('index')),
	array('label'=>'Create LibTransmission', 'url'=>array('create')),
	array('label'=>'View LibTransmission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>Update LibTransmission <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>