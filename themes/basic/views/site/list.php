<div class="row">
        <div class="col-md-8 col-lg-9 home-content">
                <div class="home-items-container">
                    <div class="home-item top category-list">
                        <div class="masonry-container">							
                            <div class="home-item-title">
                                <h2><?php echo strtoupper($name); ?></h2>
                                    <a href="" class="item-close">&nbsp;</a>
                                    <?php 
                                    if(isset($announcements) && is_array($announcements) && !empty($announcements)){
                                        foreach ($announcements as $announcement){ 
                                                $this->renderPartial('//announcement/_info',array('announcement' => $announcement));        
                                        } 
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>			
        </div>


        <div class="col-md-4 col-lg-3 home-sidebar-container">
            <?php is_null(Yii::app()->user->getId()) ?  $this->renderPartial('_login', array('model' => $login)) : ""; ?>
            <?php $this->renderPartial('_weather'); ?>
            <?php $this->renderPartial('_news'); ?>
        </div>

</div>