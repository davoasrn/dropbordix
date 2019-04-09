<?php
/* @var $this Rabo Omnikassa */
/* @var $model Rabo Omnikassa */

$this->breadcrumbs=array(
	'Rabo Omnikassa'=>array('index'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List LibTransmission', 'url'=>array('index')),
	array('label'=>'Create LibOmnikassa', 'url'=>array('create')),
	array('label'=>'View LibOmnikassa', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>Update LibOmnikassa <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>