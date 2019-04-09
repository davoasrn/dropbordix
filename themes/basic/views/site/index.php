<div class="loading" style="display:none"></div>

<div class="row">
        <div class="col-md-8 col-lg-9 home-content">
                <div class="home-items-container">
                    <?php
                    $this->widget('bootstrap.widgets.TbAlert',array('htmlOptions' => array('class' => 'index-alert'))); 
                    ?>
                    <?php
                    foreach ($widgetsData as $widgetKey => $widgetData){
                        $text = LibWidgets::model()->findByPk($widgetKey);
                        $this->renderPartial('//announcement/category',array(
                                       'widgetData' => $widgetData,
                                       'text' => $text->name,
                                       'cat_id' => $text->id,
                                       'is_widget' => 1
                                    )
                                );
                    }
                    ?>
                </div>			
        </div>


        <div class="col-md-4 col-lg-3 home-sidebar-container">
            <?php is_null(Yii::app()->user->getId()) ?  $this->renderPartial('_login', array('model' => $login)) : ""; ?>
            <?php $this->renderPartial('_weather'); ?>
            <?php $this->renderPartial('_news'); ?>
        </div>

</div>