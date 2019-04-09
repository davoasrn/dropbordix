<?php
/* @var $this AnnouncementController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Announcement',
);

$this->menu=array(
	array('label'=>'Create Announcement', 'url'=>array('create')),
	array('label'=>'Manage Announcement', 'url'=>array('admin')),
);
?>

<h1>Announcement</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
