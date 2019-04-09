<?php
/* @var $this AnnouncementPaidController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Announcement Paids',
);

$this->menu=array(
	array('label'=>'Create AnnouncementPaid', 'url'=>array('create')),
	array('label'=>'Manage AnnouncementPaid', 'url'=>array('admin')),
);
?>

<h1>Announcement Paids</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
