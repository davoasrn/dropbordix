<div class="home-item top">
        <div class="masonry-container">							
                <div class="home-item-title">
                        <h2>TOP ADVERTENTIES</h2>
                        <a href="" class="item-close">&nbsp;</a>
                </div>
				<?php foreach ($announcements as $announcement){ 
					$this->renderPartial('//announcement/_info',array('announcement' => $announcement));
				} ?>
                <div class="masonry-btn-wrapper">
                        <button class="btn btn-primary">BEKIJK ALLE</button>
                </div>
        </div>
</div>