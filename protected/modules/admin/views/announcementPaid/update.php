<?php
/* @var $this AnnouncementPaidController */
/* @var $model AnnouncementPaid */

$this->breadcrumbs=array(
	'Announcement Paids'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AnnouncementPaid', 'url'=>array('index')),
	array('label'=>'Create AnnouncementPaid', 'url'=>array('create')),
	array('label'=>'View AnnouncementPaid', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AnnouncementPaid', 'url'=>array('admin')),
);
?>

<h1>Update AnnouncementPaid <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>