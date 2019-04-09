<?php
/* @var $this LibPostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Posts',
);

$this->menu=array(
	array('label'=>'Create LibPosts', 'url'=>array('create')),
	array('label'=>'Manage LibPosts', 'url'=>array('admin')),
);
?>

<h1>Lib Posts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
