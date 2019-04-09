<?php
/* @var $this AnnouncementController */
/* @var $model Announcement */

$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Announcement', 'url'=>array('index')),
	array('label'=>'Create Announcement', 'url'=>array('create')),
	array('label'=>'Update Announcement', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Announcement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Announcement', 'url'=>array('admin')),
);
?>

<h1>View Announcement #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'category_id',
		'status',
		'description',
		'start_date',
		'end_date',
		'user_id',
		'add_date',
		'change_date',
		'price',
	),
)); ?>
