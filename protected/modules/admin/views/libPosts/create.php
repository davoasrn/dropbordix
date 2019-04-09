<?php
/* @var $this LibPostsController */
/* @var $model LibPosts */

$this->breadcrumbs=array(
	'Lib Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LibPosts', 'url'=>array('index')),
	array('label'=>'Manage LibPosts', 'url'=>array('admin')),
);
?>

<h1>Create LibPosts</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>