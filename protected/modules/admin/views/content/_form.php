<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'is_published'); ?>
	<?php echo $form->dropDownList($model,
'is_published',
array(0 => 'No', 1 => 'Yes'),
array('prompt'=>'Select') ); ?>
		<?php echo $form->error($model,'is_published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page_title'); ?>
		<?php echo $form->textField($model,'page_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'page_title'); ?>
	</div>

	
<div class="row">
    <?php echo $form->labelEx($model,'content'); ?>
    <?php echo $form->textArea($model,'content',array('rows'=>20, 'cols'=>120, 'id'=>'Champion_text_CK')); ?>
    <?php echo $form->error($model,'content'); ?>
</div>

<?php $this->widget('ext.JCKEditor.JCKEditorWidget', array(
    'id' => 'Champion_text_CK',        
    'height' => '200px',
    'width' => '600px',
    'toolbar' => 'myToolbar',
    'path' => Yii::app()->getBaseUrl(true).'/ckeditor4/',
    'config'=>array(
        'language'=> 'en',
    )
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_description'); ?>
		<?php echo $form->textField($model,'meta_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->