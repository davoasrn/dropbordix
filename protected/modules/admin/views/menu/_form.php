<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_id'); ?>
		<!--<?php echo $form->textField($model,'cat_id'); ?>-->
            
            
              <?php echo $form->dropDownList($model,'cat_id',CHtml::listData(MenuCat::model()->findAll(), 'id', 'cat_name'),array('empty'=>'(Select a category'));?>
            
            
		<?php echo $form->error($model,'cat_id'); ?>
            
            
            
            
	</div>

	<div class="row">
		
            
            
            
          
            
            <?php echo $form->labelEx($model,'page_id'); ?>
		<!--<?php echo $form->textField($model,'page_id'); ?>-->
            
            
            
            
              <?php echo $form->dropDownList($model,'page_id',CHtml::listData(Content::model()->findAll(), 'id', 'page_title'),array('empty'=>'(Select a page'));?>
            
		<?php echo $form->error($model,'page_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->