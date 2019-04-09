<?php
/* @var $this LibPostsController */
/* @var $model LibPosts */

$this->breadcrumbs=array(
	'Lib Posts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LibPosts', 'url'=>array('index')),
	array('label'=>'Create LibPosts', 'url'=>array('create')),
	array('label'=>'Update LibPosts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibPosts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LibPosts', 'url'=>array('admin')),
);
?>

<h1>View LibPosts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'country_code',
		'postal_code',
		'place_name',
		'state',
		'state_code',
		'province',
		'province_code',
		'community',
		'communit_code',
		'latitude',
		'longitude',
		'lat_lag',
	),
)); ?>
