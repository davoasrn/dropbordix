<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php
        $errorSummary = array($model,$autoDetail);
        echo $form->errorSummary($errorSummary); 
        ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model,'type_id',CHtml::listData(LibTypes::model()->findAll(),'id','name'),array('empty' => 'Select a name')); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',CHtml::listData(LibCategoryStatus::model()->findAll(),'id','name'),array('empty' => 'Select a name')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

        
        
	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' =>$model,
                    'name'=>'start_date',
                    'value'=>date('Y-m-d'),    
                    'options'=>array(
                        'showAnim'=>'slideDown',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                        'showButtonPanel'=>true,
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'style'=>''
                    ),
                ));
                ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' =>$model,
                    'name'=>'end_date',
                    'value'=>date('Y-m-d'),    
                    'options'=>array(
                        'showAnim'=>'slideDown',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                        'showButtonPanel'=>true,
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'style'=>''
                    ),
                ));
                ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',CHtml::listData(Users::model()->findAll(),'id','email'),array('empty' => 'Select a name')); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
        
	<div class="row car">
		<?php $this->renderPartial('/autoDetail/_form',array('model'=>$autoDetail,'form' =>$form)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->