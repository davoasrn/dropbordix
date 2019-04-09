<?php
/* @var $this LibTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Types',
);

$this->menu=array(
	array('label'=>'Create LibTypes', 'url'=>array('create')),
	array('label'=>'Manage LibTypes', 'url'=>array('admin')),
);
?>

<h1>Lib Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
