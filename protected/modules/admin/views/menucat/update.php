<?php
/* @var $this MenuCatController */
/* @var $model MenuCat */

$this->breadcrumbs=array(
	'Menu Cats'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MenuCat', 'url'=>array('index')),
	array('label'=>'Create MenuCat', 'url'=>array('create')),
	array('label'=>'View MenuCat', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MenuCat', 'url'=>array('admin')),
);
?>

<h1>Update MenuCat <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>