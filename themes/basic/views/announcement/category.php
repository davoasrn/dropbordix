<div class="home-item top">
        <div class="masonry-container">							
                <div class="home-item-title">
                    <h2><?php echo strtoupper($text); ?></h2>
                        <a href="" class="item-close">&nbsp;</a>
                </div>
                    <?php 
                        foreach ($widgetData as $announcement){ 
                                $this->renderPartial('//announcement/_info',array('announcement' => $announcement));
                        } 
                    ?>
                   
                <div class="masonry-btn-wrapper">
                        <?php echo CHtml::tag('button', array('class'=>'btn btn-primary','onclick' => 'js:document.location.href="index.php?r=site/list&id='.$cat_id.'&is_widget='.$is_widget.'"'),'BEKIJK ALLE'); ?>
                </div>
        </div>
</div>