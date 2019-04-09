<div class="adv-map-container">
        <?php 
        if(isset($model)){
            $place = (isset($model->place_name) && !empty($model->place_name)) ? $model->place_name : "no place";
            $state = (isset($model->state) && !empty($model->state)) ? $model->state : "no state"; 
            echo $place.', '.$state;
        ?>
            <div class="map-img <?php echo $place.' '.$state; ?>">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/map.png">
            </div>
        <?php } ?>
</div>