 <?php  Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<div class="modal-page adv-placing-container adv-open-container" id="printTable">
    <div class="item-close-wrapper">
            <span class="hidden-xs"></span>
            <a href="" class="item-close">&nbsp;</a>
    </div>
    <h2 class="main-title">
    <?php 
        echo CHtml::encode($model->name); 
    ?>
    </h2>
    <?php 
            $this->widget('bootstrap.widgets.TbAlert',array('htmlOptions' => array('class' => 'index-alert'))); 
    ?>
    <p class="sub-title">Geplaatst op: <?php echo $model->add_date; ?></p>
    <?php if((isset($model->site_url) && !empty($model->site_url) && !isset($model->announcementPaidSite)) 
            || (isset($model->video_url) && !empty($model->video_url) && !isset($model->announcementPaidVideo))){ ?>
    <div class="adv_payment">
        <?php 
            /**
             * payment page, form for submiting payment
             * @param int $id Announcement
             */
            if(isset($model->site_url) && !empty($model->site_url) && !isset($model->announcementPaidSite))
                $this->renderPartial('//payments/_paymentFormSite',array('id' =>$model->id)); 
            if(isset($model->video_url) && !empty($model->video_url) && !isset($model->announcementPaidVideo))
                $this->renderPartial('//payments/_paymentFormVideo',array('id' =>$model->id)); 
        ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-9 adv-content">

            <?php //$this->renderPartial('_imageView'); ?>
            <?php $this->renderPartial('_imageDemoView',array('model' => $model,'user' => $user)); ?>



            <?php echo CHtml::encode($model->description); ?>
            <div class="direct-container">
                    <h2>Direct reageren</h2>
                    <?php 
                            /*
                            *comment page for viewing comments for current announcement
                            *@param $comments is all comments for that announcements from Comments table
                            *@param $model for creating new comment for that announcement
                            *@param $announcement Announcement model data
                            */
                            $this->renderPartial('comment',
                                                    array(
                                                            'comments' =>$comments,
                                                            'model' => $newComment,
                                                            'announcement' =>$model
                                                    ),false,true
                                            );
                    ?>

                    <?php 
                    /*
                     * view page for showing resilts like opened announcement
                     */
                    $this->renderPartial('sameResult',array('sameResult' => $sameResult));
                    ?>

            </div>

        </div>
        <div class="col-md-3">
                <div class="adv-form-container">
                        <h2>Kenmerken</h2>
                        <h5><?php echo CHtml::encode($model->name); ?></h5>
                        <?php if($model->category->parent_id == 1){ ?>
                        <table>
                                <tr>
                                        <td class="semi">Bouwjaar</td><td><?php echo CHtml::encode($auto_detail->year); ?></td>
                                </tr>
                                <tr>
                                        <td class="semi">km stand</td><td><?php echo CHtml::encode($auto_detail->mileage); ?></td>
                                </tr>
                                <tr>
                                        <td class="semi">Transmissie</td><td><?php echo isset($auto_detail->transmission) ? CHtml::encode($auto_detail->transmission->name) : ""; ?></td>
                                </tr>

                                <tr>
                                        <td class="semi">Brandstof</td><td><?php echo CHtml::encode($auto_detail->fuel->name); ?></td>
                                </tr>
                        </table>
                        <?php } 
                        
                        echo CHtml::link(
                                        '<i class="fa fa-facebook-square"></i>
                                            DEEL OP FACEBOOK', 
                                        '#', 
                                        array(
                                            'onclick'=>"Share.facebook('".Yii::app()->homeUrl.$this->createUrl('announcement/view',array('id' => $model->id))."','".$model->name."','".(isset($model->file) ? $model->file->name : "")."','')",
                                            'class' =>'btn btn-social'
                                            )
                                        ); 
                        echo CHtml::link(
                                        '<i class="fa fa-twitter"></i>
                                            DEEL OP TWITTER', 
                                        '#', 
                                        array(
                                            'onclick'=>"Share.twitter('".Yii::app()->homeUrl.$this->createUrl('announcement/view',array('id' => $model->id))."','".$model->name."','".(isset($model->file) ? $model->file->name : "")."','')",
                                            'class' =>'btn btn-social'
                                            )
                                        ); 
                        
                        ?>

                       <!-- <a href="#" class="btn btn-social">
                                <i class="fa fa-facebook-square"></i>
                                DEEL OP FACEBOOK
                        </a>
                        -->
<!--                        <a href="#" class="btn btn-social">
                                <i class="fa fa-twitter"></i>
                                DEEL OP TWITTER
                        </a>-->
                        <p>
                                Vraagprijs:<br>
                                <strong>
                                        <?php echo "€".CHtml::encode($model->price).",-"; ?>
                                </strong><br>
                                (Of doe een bod met de biedfuncte)
                        </p>
                </div>
                <?php 
                    /*
                     * User info
                     */
                    $this->renderPartial('//users/user_info',array('model' => $user,'announcement' => $model)); 
                ?>

                <div class="adv-uitloggen">
                        <?php 
		if((!is_null(Yii::app()->user->getId()) && isset($model->user_id) && Yii::app()->user->getId() != $model->user_id) || is_null(Yii::app()->user->getId())) { 
                        echo CHtml::tag('button', array(
                                'type'=>'submit', 
                                'class'=>'btn btn-primary',
                                'data-href'=>Yii::app()->createUrl('announcement/emailAnnouncement',array('id' => $model->id)) ,
                                'onclick' => 'js:navigation(this)'
                                ),'EMAIL DEZE ADVERTEERDER');
						}
                        ?>

                        <?php if (isset($model->site_url) && !empty($model->site_url) && isset($model->announcementPaidSite)){ 
                            echo CHtml::tag('button', array(
                                'type'=>'submit', 
                                'class'=>'btn btn-primary',
                                'onclick' => 'js:window.open("'.$model->site_url.'", "_blank");'
                                ),'GA NAAR DE WEBSITE VAN<br>DEZE ADVERTEERDER');
                         } ?>
                </div>
                <?php 
                    /*
                     * User location info
                     * @param $user Users model
                     */
                    $this->renderPartial('//users/map',array('model' => $user->postalCode)); 
                ?>
                <?php
                
                    /*
                     * set payment for announcement
                     * @param $model Announcement 
                     * @param $payments Payments
                     */
                     if(isset($model->bid) && !empty($model->bid))
                        $this->renderPartial('//payments/_form',array('announcement' => $model,'payments' => $payments)); 
                ?>

                <div class="adv-bottom-ections">
                        <ul>
                                <li>
                                        <?php 
                                        if (! Is_null (yii::app()->user-> getId ()))
                                            echo CHtml::link(
                                            CHtml::image(Yii::app()->theme->baseUrl.'/img/save-icon.png','email').'<p>Bewaar deze<br>advertentie</p>', 
                                            '#', 
                                            array(
                                                'data-href'=>Yii::app()->createUrl('announcement/saveAnnouncement'),
                                                'data-id' => $model->id,
                                                'onclick' => 'js:saveAnnouncement(this)'
                                                )
                                            ); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link(
                                            CHtml::image(Yii::app()->theme->baseUrl.'/img/icon1.png','email').'<p>Mail deze<br>advertentie</p>', 
                                            '#', 
                                            array(
                                                'data-href'=>Yii::app()->createUrl('announcement/emailAnnouncement',array('id' => $model->id)) ,
                                                'onclick' => 'js:navigation(this)'
                                                )
                                            ); ?>
                                </li>
                                <li>
                                    <?php echo CHtml::link(
                                                CHtml::image(Yii::app()->theme->baseUrl.'/img/print-icon.png','print').'<p>Print deze <br>advertentie</p>', 
                                                '#', 
                                                array(
                                                    'data-href'=>Yii::app()->createUrl('announcement/emailSpam',array('id' => $model->id)) ,
                                                    'onclick' => 'js:PrintDiv()'
                                                    )
                                                ); ?>
                                </li>
                                <li>
                                        <?php echo CHtml::link(
                                                CHtml::image(Yii::app()->theme->baseUrl.'/img/flag-icon.png','email').'<p>Bewaar deze<br>of tip dropbord</p>', 
                                                '#', 
                                                array(
                                                    'data-href'=>Yii::app()->createUrl('announcement/emailSpam',array('id' => $model->id)),
                                                    'onclick' => 'js:navigation(this)'
                                                    )
                                                ); ?>
                                </li>
                        </ul>
                </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
    function PrintDiv() {    
           var divToPrint = document.getElementById('printTable');
           var popupWin = window.open('', '_blank', 'width=680');
           popupWin.document.open();
           popupWin.document.write('<html><style>#printTable{width:680px;}  #printSpan{float:right;} </style><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>

