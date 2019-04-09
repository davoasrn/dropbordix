<?php
/* @var $this MenuController */
/* @var $data Menu */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_id')); ?>:</b>
	<?php //echo CHtml::encode($data->cat_id);
        
        
        
        
         $cat=new MenuCat;
        
        
        
        $contentName=$cat->findByPk($data->cat_id);
        
        echo $contentName->cat_name;
        
        
        
        ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('page_id')); ?>:</b>
	<?php //echo CHtml::encode($data->page_id);
        
        $cat=new Content;
        
        
        
        $contentName=$cat->findByPk($data->page_id);
        
        echo $contentName->page_title;
        
        
        ?>
	<br />


</div>