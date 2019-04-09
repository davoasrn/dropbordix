<?php
/* @var $this LibWidgetsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Widgets',
);

$this->menu=array(
	array('label'=>'Create LibWidgets', 'url'=>array('create')),
	array('label'=>'Manage LibWidgets', 'url'=>array('admin')),
);
?>

<h1>Lib Widgets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
