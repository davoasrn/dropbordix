<?php
if(isset($user)){
    $imagePath = '/images/'.$user->id."/";
    $imageThumb = '/images/'.$user->id."/thumbs/";
}else {
    $imagePath = '/images/';
    $imageThumb = '/images/thumbs/';
}
$i = 1;
$vertical = array();
?>
<div class="add-photo-container ">
    <div class="click-photo-wrapper ">
    <?php
    if(isset($model->video_url) && !empty($model->video_url) && isset($model->announcementPaidVideo)){ ?>
        <div class="click-photo" style="background: center; background-size:cover;">	
            <object width="100%" height="100%" ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"
                    data="<?php echo (file_exists(Yii::app()->basePath.'/..'.$imagePath.$model->video_url)) 
                            ? $imagePath.$model->video_url 
                            : $model->video_url; ?>">
            </object>
        </div>
    <?php }else{ ?>
        
    <div class="click-photo" style="background:url('<?php echo isset($model->files[0]) ? $imagePath.$model->files[0]->name : Yii::app()->theme->baseUrl.'/img/item-img.png'; ?>') center center; background-size:cover;">	
            <!--<div class="click-photo" style="background-image:url('<?php echo Yii::app()->theme->baseUrl; ?>/img/car.png')">	
                   <a href="">
                            <img src="<?php // echo Yii::app()->theme->baseUrl; ?>/img/play.png">
                    </a>
                    -->
            </div>
        <?php } ?>
    </div>
    <div class="item-photos">
            <?php 
            
                foreach ($model->files as $key=>$file){

                    echo '<div class="photo-item-wrapper">';
                    if($i == 3){
                        $countImage = count($model->files) - 3;
                        $vertical[] = $key;
                        if($countImage > 0){
                            echo '<div class="item1 last-item"  onmouseover="changeMainImageBackground(this)" style="background-image:url('.$imageThumb.$file->name.')">
                                        <a id="more-photos" title="<p>'.htmlentities($model->name,ENT_QUOTES).'.</p> <span>&euro;'.$model->price.',-</span>" href="'.$imagePath.$file->name.'" data-lightbox="roadtrip" class="fancybox-thumbs" data-fancybox-group="thumb">
                                            <i class="fa fa-plus"></i>
                                            <span> '.$countImage.'</span>
                                        </a>
                                  </div>';
                         }else{
                             echo '<div class="item1" onmouseover="changeMainImageBackground(this)" style="background-image:url('.$imageThumb.$file->name.')">
                                        <a href="'.$imagePath.$file->name.'" title="<p>'.htmlentities($model->name,ENT_QUOTES).'.</p> <span>&euro;'.$model->price.',-</span>" data-lightbox="roadtrip" class="fancybox-thumbs" data-fancybox-group="thumb">
                                        </a>
                                  </div>';
                         }
                    }elseif($i < 3){
                        $vertical[] = $key;
                        echo '<div class="item1" onmouseover="changeMainImageBackground(this)" style="background-image:url('.$imageThumb.$file->name.')">
                                        <a href="'.$imagePath.$file->name.'" title="<p>'.htmlentities($model->name,ENT_QUOTES).'.</p> <span>&euro;'.$model->price.',-</span>" data-lightbox="roadtrip" class="fancybox-thumbs" data-fancybox-group="thumb">
                                        </a>
                              </div>';
                    }elseif($i > 3){
                        $vertical[] = $key;
                        echo '<div style="display:none" class="item1" onmouseover="changeMainImageBackground(this)" style="background-image:url('.$imageThumb.$file->name.')">
                                        <a href="'.$imagePath.$file->name.'" title="<p>'.htmlentities($model->name,ENT_QUOTES).'.</p> <span>&euro;'.$model->price.',-</span>" data-lightbox="roadtrip" data-fancybox-group="thumb" class="fancybox-thumbs">
                                        </a>
                              </div>';
                    }
                    echo '</div>';
                    $i++;
                } 
            ?>
    </div>
</div>
