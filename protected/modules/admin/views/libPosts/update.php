<?php
/* @var $this LibPostsController */
/* @var $model LibPosts */

$this->breadcrumbs=array(
	'Lib Posts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LibPosts', 'url'=>array('index')),
	array('label'=>'Create LibPosts', 'url'=>array('create')),
	array('label'=>'View LibPosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LibPosts', 'url'=>array('admin')),
);
?>

<h1>Update LibPosts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>