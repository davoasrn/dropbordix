<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Rabo Omnikassa'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List LibTransmission', 'url'=>array('index')),
	array('label'=>'Create LibTransmission', 'url'=>array('create')),
	array('label'=>'Update LibTransmission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LibTransmission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage LibTransmission', 'url'=>array('admin')),
);
?>

<h1>Rabo Omnikassa #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'merchant_id',
		'security_key',
		'security_key_version',
		'video_price',
		'site_url_price',
                array(
                    'name' => 'status',
                    'value' => ($model->status == 1) ? 'enabled ' : 'disabled'
                )
	),
)); ?>
