<style type = "text/css">
    .car-data { display:none; }
</style>

<div class="adv-form-container">
            <h2>Kenmerken</h2>
                    <div class="form-group">
                            <?php echo $form->labelEx($announcement,'category_id'); ?>
                            <?php echo $form->dropDownList(
                                                            $announcement,
                                                            'category_id',
                                                            CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => 0)),'id','name'),
                                                                    array(
                                                                        'class'=>"form-control parent", 
                                                                        'empty' => 'Choose Category',
                                                                        'data-href' => $this->createUrl('site/parentType'),
                                                                        'onchange'=>'js:car_data(this);'
                                                                        )
                                    ); ?>
                            <?php echo $form->error($announcement,'category_id'); ?>
                    </div>
                    <?php
                    if(Yii::app()->controller->action->id == 'update'){
                        $categories = explode('-',$announcement->category_saved);
//                        $key = array_search($announcement->category_id, $categories);
//                        $categ = LibCategory::model()->findByPk($categories[$key]);
//                        unset($categories[$key]);
                        $parent = 0;
                        foreach (array_reverse($categories) as $category){
                            $category = explode(',', $category);
                            $curent = LibCategory::model()->findByPk($category['0']);
                            $childs = CHtml::listData($curent->childs,'id','name');
                            
                            if(isset($childs) && !empty($childs) && is_array($childs)){
                                echo '<div class="form-group child parent_'.$curent->parent_id.'"><br />';
                                echo CHtml::dropDownList('LibCategory[parent]['.$curent->parent_id.']', '',$childs,
                                array(
                                    'empty' => 'Select type',
                                    'data-href' => $this->createUrl('site/parentType'),
                                    'onchange' => 'js:changeCategory(this)',
                                    'class' => 'form-control',
                                    'data-parent' => $curent->parent_id,
                                    'options' => array(isset($category['1']) ? $category['1'] : null =>array('selected'=>true)),
                                    )
                                );
                                echo "</div>";
                            }
                        }
                    }
                    ?>
                    <div class='buttons' style="display:none"></div>
                    <div class="form-group car-data">
                            <?php echo $form->labelEx($model,'year'); ?>
                            <?php echo $form->dropDownList($model,'year', range(date('Y'),1900,-1), 
                                                                    array('class'=>"form-control", 'empty' => 'Choose Year')); ?>
                            <?php echo $form->error($model,'year'); ?>
                    </div>
                    <div class="form-group car-data">
                            <?php echo $form->labelEx($model,'mileage'); ?>
                            <?php echo $form->textField($model,'mileage',
                                                                    array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Km stand")); ?>
                            <?php echo $form->error($model,'mileage'); ?>
                    </div>
                    <div class="form-group car-data">
                            <?php echo $form->labelEx($model,'transmission_id'); ?>
                            <?php echo $form->dropDownList($model,'transmission_id',  CHtml::listData(LibTransmission::model()->findAll(),'id','name'), 
                                                                    array('class'=>"form-control", 'empty' => 'Choose type')); ?>
                            <?php echo $form->error($model,'transmission_id'); ?>
                    </div>
                    <div class="form-group car-data">
                            <?php echo $form->labelEx($model,'fuel_id'); ?>
                            <?php echo $form->dropDownList($model,'fuel_id',  CHtml::listData(LibFuelTypes::model()->findAll(),'id','name'), 
                                                                    array('class'=>"form-control", 'empty' => 'Choose type')); ?>
                            <?php echo $form->error($model,'fuel_id'); ?>
                    </div>
                    <?php if(Yii::app()->controller->action->id != 'update'){ ?>
                        <div class="form-group">
                                <?php echo $form->labelEx($announcement,'price'); ?>
                                <?php echo $form->textField($announcement,'price',
                                                                        array('size'=>60,'maxlength'=>255,'class'=>"form-control",'placeholder'=>"Enter Price")); ?>
                                <?php echo $form->error($announcement,'price'); ?>
                        </div>
                    <?php }else{ ?>
                        <div class="form-group">
                                <?php echo $form->labelEx($announcement,'status'); ?>
                                <?php echo $form->dropDownList($announcement,'status',  CHtml::listData(LibAnnouncementStatus::model()->findAll(),'id','name'), 
                                                                    array('class'=>"form-control", 'empty' => 'Choose type')); ?>
                                <?php echo $form->error($announcement,'status'); ?>
                        </div>
                    <?php } ?>
</div>
<script type="text/javascript">
    var data = document.getElementById('Announcement_category_id');
    car_data(data);
    
    $(document).ready(function(){
        $("#Announcement_category_id").change(function(){
            changeCategory(data);
        })
    });
</script>