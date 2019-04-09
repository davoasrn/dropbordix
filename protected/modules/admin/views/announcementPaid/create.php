<?php
/* @var $this AnnouncementPaidController */
/* @var $model AnnouncementPaid */

$this->breadcrumbs=array(
	'Announcement Paids'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AnnouncementPaid', 'url'=>array('index')),
	array('label'=>'Manage AnnouncementPaid', 'url'=>array('admin')),
);
?>

<h1>Create AnnouncementPaid</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>