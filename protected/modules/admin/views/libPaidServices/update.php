<?php
/* @var $this LibPaidServicesController */
/* @var $model LibPaidServices */

$this->breadcrumbs=array(
	'Lib Paid Services'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibPaidServices', 'url'=>array('index')),
	array('label'=>'Create LibPaidServices', 'url'=>array('create')),
	array('label'=>'View LibPaidServices', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibPaidServices', 'url'=>array('admin')),
);
?>

<h1>Update LibPaidServices <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>