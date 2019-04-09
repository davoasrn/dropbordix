<?php
/* @var $this LibTransmissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lib Transmissions',
);

$this->menu=array(
	array('label'=>'Create LibTransmission', 'url'=>array('create')),
	array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>Lib Transmissions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
