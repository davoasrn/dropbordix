<?php
/* @var $this libCategoryController */
/* @var $model libCategory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lib-category-status-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
                <?php echo $form->dropDownList($model,
                        'parent_id',
                        CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => 0)),'id','name'),
                        array(
                            'empty' => 'Select a name',
                            'onchange' => 'js:change(this)',
                            'data-href' => $this->createUrl('libCategory/parent'),
                            )); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->