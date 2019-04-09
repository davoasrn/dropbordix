<?php
/* @var $this LibFuelTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Fuel Types',
);

$this->menu=array(
	array('label'=>'Create LibFuelTypes', 'url'=>array('create')),
	array('label'=>'Manage LibFuelTypes', 'url'=>array('admin')),
);
?>

<h1>Lib Fuel Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
