<?php
/* @var $this LibTransmissionController */
/* @var $model LibTransmission */

$this->breadcrumbs=array(
	'Lib Omnikassa'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LibOmnikassa', 'url'=>array('index')),
	array('label'=>'Create LibOmnikassa', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lib-omnikassa-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lib Omnikassa</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lib-omnikassa-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'name',
		'merchant_id',
		'security_key',
		'security_key_version',
		'video_price',
		'site_url_price',
                array(
                    'name' => 'status',
                    'value' => '$data->status == 1 ? "enabled" : "disabled"',
                    'filter' => array(0=>"disabled",1=>"enabled")
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
