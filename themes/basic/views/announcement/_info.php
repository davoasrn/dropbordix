<?php

if(isset($announcement->file) && isset($announcement->user) && file_exists('images/'.$announcement->user->id.'/thumbs/'.$announcement->file->name)){
    $photoc = $photo = 'images/'.$announcement->user->id.'/thumbs/'.$announcement->file->name;
}
//else{
//    $photo = Yii::app()->theme->baseUrl."/img/item-img.png"; $photoc = ltrim ($photo, '/');
//}
$status = "";
if($announcement->status ==LibAnnouncementStatus::reserved){
    $status = "reserved";
}elseif ($announcement->status ==LibAnnouncementStatus::sold) {
    $status = "sold";
}
?>

<div class="item <?php echo $status; ?>">
    <?php if(isset($photo) && !empty($photo)){ ?>
        <div class="home-item-img-container">
                <div class="home-item-img">
                        <a href="#" onclick="js:navigation(this);" data-href="<?php echo Yii::app()->createUrl('announcement/view',array('id' =>$announcement->id)); ?>">
                            <img src="<?php echo $photo ?>" class="img-responsive"></a>
                        <div class="price-wrapper <?php $palette = Functions::get_avg_luminance($photoc, 10); 
                        if($palette > 115) echo 'white'; else echo $palette;?>">
                            <?php echo '€'.$announcement->price.',-'; ?></div>
                </div>
                <div class="home-item-data">
                        <div class="date"><?php echo CHtml::encode($announcement->add_date); ?></div>
                        <div class="location"><?php echo CHtml::encode(isset($announcement->user) ? $announcement->user->postal_code : ""); ?></div>
                        <div class="comments"><a href="#" onclick="js:navigation(this);" data-href="<?php echo Yii::app()->createUrl('announcement/view',array('id' =>$announcement->id)); ?>">
                                <i class="fa fa-comment"></i>Reacties (<?php echo CHtml::encode($announcement->commentsCount); ?>)</a> </div>
                </div>
        </div>
    <?php } ?>
    <div class="home-item-description">
            <p><strong><?php echo CHtml::encode($announcement->name); ?></strong></p>
            <p><?php echo CHtml::encode(Functions::shortDescription($announcement->description)); ?></p>
            <div class="home-item-description-btn">									
                    <button 
                            class="btn btn-primary" 
                            onclick = "js:navigation(this);"
                            data-href = "<?php echo Yii::app()->createUrl('announcement/view',array('id' =>$announcement->id)); ?>" >
                            BEKIJK 
                            <i class="fa fa-chevron-right"></i>
                    </button>
            </div>								
    </div>
</div>