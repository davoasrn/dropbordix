<?php
/* @var $this LibCategoryStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Category Statuses',
);

$this->menu=array(
	array('label'=>'Create LibCategoryStatus', 'url'=>array('create')),
	array('label'=>'Manage LibCategoryStatus', 'url'=>array('admin')),
);
?>

<h1>Lib Category Statuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
