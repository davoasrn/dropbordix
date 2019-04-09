<?php
/* @var $this MenuCatController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Menu Cats',
);

$this->menu=array(
	array('label'=>'Create MenuCat', 'url'=>array('create')),
	array('label'=>'Manage MenuCat', 'url'=>array('admin')),
);
?>

<h1>Menu Cats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
