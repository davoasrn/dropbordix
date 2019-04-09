
<h2>Vergelijkbaar</h2>
<div class="bottom-row">
        <ul>
            <?php foreach ($sameResult as $result){ 
                
            if(isset($result->user)){    
                $imageThumb = '/images/'.$result->user->id.'/thumbs/';
            }else{
                $imageThumb = '/images/thumbs/';
            }
            ?>
                <li>
                        <a href="#" onclick="js:navigation(this);" data-href = "<?php echo Yii::app()->createUrl('announcement/view',array('id' =>$result->id)); ?>" >
                                <div class="bottom-row-item">
                                        <div class="bottom-img-container" style="background-image:url('<?php  echo (isset($result->file) /*&& file_exists($imageThumb.$result->file->name)*/) ? $imageThumb.$result->file->name : Yii::app()->theme->baseUrl."/img/item-img.png"; ?>')">
                                        </div>
                                </div>
                                <p>
                                        <strong>
                                                <?php echo $result->name; ?>
                                        </strong><br>
                                        <?php 
                                        if($result->category_id == LibCategory::CAR && isset($result->autoDetails)){ 
                                            echo !empty($result->autoDetails->mileage) ? $result->autoDetails->mileage.'<br />' : "";
                                            echo !empty($result->autoDetails->fuel) ? $result->autoDetails->fuel->name." " : " ";
                                            echo !empty($result->autoDetails->transmission) ? $result->autoDetails->transmission->name : "<br />";
                                        }
                                        ?>
                                        <?php echo '€'.$result->price.',-'; ?>
                                </p>
                        </a>
                </li>
            <?php } ?>
        </ul>
</div>