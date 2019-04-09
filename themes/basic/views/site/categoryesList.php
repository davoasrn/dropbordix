<div class="row">
        <div class="col-md-8 col-lg-9 home-content">
                <div class="home-items-container">
                    <?php
                    $this->widget('bootstrap.widgets.TbAlert',array('htmlOptions' => array('class' => 'index-alert'))); 
                    ?>
                    <?php
                    /*
                    *Showing top announcements
                    */
                    foreach ($categories as $catId => $catName){
                        $announcements = Announcement::model()->findAllByAttributes(array('category_id' =>$catId));
                        $this->renderPartial('//announcement/category',array(
                                'widgetData' =>$announcements,
                                'text' =>$catName,
                                'cat_id' => $catId,
                                'is_widget' => 0
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