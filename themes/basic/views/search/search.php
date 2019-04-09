<div class="home-item search" >
        <div class="masonry-container">
                <div class="home-item-title">
                        <h2>ZOEKOPDRACHT: <?php echo $keyword; ?> </h2>
                        <a href="" class="item-close">&nbsp;</a>
                </div>
                <?php 
                if(isset($model) && !empty($model)){
                    foreach ($model as $announcement){ 
                        $this->renderPartial('//announcement/_info',array('announcement' => $announcement));
                    } 
                    ?>
                    <div class="masonry-btn-wrapper">
                            <button class="btn btn-primary">BEKIJK ALLE</button>
                    </div>
                <?php
                }  else {
                    echo 'Er is geen resultaat';
                }
                   ?>
                
                
        </div>
</div>