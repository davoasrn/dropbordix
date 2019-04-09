<?php
/* @var $this AnnouncementPaidController */
/* @var $model AnnouncementPaid */

$this->breadcrumbs=array(
	'Announcement Paids'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AnnouncementPaid', 'url'=>array('index')),
	array('label'=>'Create AnnouncementPaid', 'url'=>array('create')),
	array('label'=>'Update AnnouncementPaid', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AnnouncementPaid', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AnnouncementPaid', 'url'=>array('admin')),
);
?>

<h1>View AnnouncementPaid #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array(
                    'name' => 'announcement_id',
                    'type' => 'raw',
                    'value' => isset($model->announcement) ? CHtml::link($model->announcement->name,array("announcement/view","id" => $model->announcement_id)) : ""
                ),
                array(
                    'name' => 'type_id',
                    'type' =>'raw',
                    'value' => isset($model->type) ? $model->type->name : ""
                ),
		'order_id',
		'url',
		'paid',
		array(
                    'name' => 'status',
                    'type' =>'raw',
                    'value' => isset($model->statusPay) ? $model->statusPay->name : ""
                ),
		'add_date',
		'change_date',
                array(
                    'name' => 'user_id',
                    'type' => 'raw',
                    'value' => isset($model->user) ? CHtml::link($model->user->name,array("users/view","id" => $model->user_id)) : ""
                ),
	),
)); ?>
