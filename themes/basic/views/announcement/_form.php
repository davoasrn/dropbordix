<div class="modal-page adv-notlogged">
        <div class="item-close-wrapper">
                <span></span>
                <a href="" class="item-close">&nbsp;</a>
        </div>

        <h2>Advertentie plaatsen</h2>
        <?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'announcement-create-form',
                'action' => (Yii::app()->controller->action->id == 'update') ? Yii::app()->createUrl($checkAction,array('id'=>$model->id)) : Yii::app()->createUrl($checkAction),
		'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=> true,
                    'afterValidate' =>'js:function(form,data,hasError){
                        if(!hasError){
                            var formData = new FormData($("#announcement-create-form")[0]);
                            formData.append( "file",  $("#Announcement_video")[0].files[0] );
                            //console.log(formData);
                            $.ajax({
                                "type" : "POST",
                                "url"  : "'.CHtml::normalizeUrl($url).'",
                                //"data" : form.serialize(),
                                "data" : formData,
                                datatype :"json",
                                cache : false,
                                contentType : false,
                                processData : false,
                                "success" : function(data) {
                                  var action = "'.Yii::app()->controller->action->id.'";
                                  var json = JSON.parse(data);
                                  if(action == "update"){
                                      window.location.replace("'.Yii::app()->createUrl('site/show').'&id="+json.id);
                                }else{
                                    if(json.status=="saved"){
                                        url = "'.Yii::app()->createUrl('announcement/view').'&id="+json.id
                                        console.log(url);
                                        navigationToView(url);
                                    } 
                                }
                            }
                            });
                        }else{
                            $( ".error input, .error select" ).focus();
                        }
                    }'
                )
        )); ?>
        <div class="row">
                <div class="col-md-9 adv-input">
                        <div class="form-group ">
                                <?php echo $form->textField($model,'name',array('placeholder'=>"Seat Ibiza 1.6 SE 1998",'class'=>"form-control")); ?>
                                <?php  echo $form->error($model,'name'); ?>
                                <?php // echo TbHtml::em($form->error($model,'name'), array('color' => TbHtml::TEXT_COLOR_ERROR)); ?>
                                <span>*</span>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-md-9 adv-content" >

                        <?php
                            //real upload
                            //$this->renderPartial('_imageUpload'); 
                            //real upload
                            $this->renderPartial('_imageDemo',array(
                                        'model' => $files,
                                        'user'=>$users,
                                        'announcement'=>$model,
                                        'uploadedFiles' => isset($uploadedFiles) ? $uploadedFiles : null,
                                        )
                                    );
                        ?>
                        <div class="textarea-wrapper">
                            <?php echo $form->textArea($model,'description',array('placeholder'=>"HIER UW VERHAAL",'class'=>'form-control'));  ?>
                        </div>				
                </div>
                <div class="col-md-3 adv-sidebar" style="display:block !important">
                        <?php $this->renderPartial('_car_form',array('model' => isset($auto_detail) ? $auto_detail : new AutoDetail, 'form' => $form, 'announcement' => $model)); 
                                if(Yii::app()->controller->action->id == 'create')
                                        $this->renderPartial('//users/user_info',array('model' => $users)); 
                        ?>
                    
                        <div class="adv-bieden-container">
                                <div class="bieden-title">
                                        <h4>BIEDEN</h4>
                                        <!-- Slide THREE -->
                                        <div class="adv-slide-checkbox-wrapper">
                                                <div class="adv-slide-checkbox">	
<!--                                                    <input type="checkbox" value="None" id="slideThree" name="check" style="display:none" onchange="$('.bieden-content').toggle('slow')" />-->
<script>
$( ".ena" )
  .change(function () {
    $('.bieden-content').toggle('slow');
	if($('.adv-slide-checkbox').hasClass('opened') == true)
	 {
	 $('.adv-slide-checkbox').removeClass('opened');
	 $(".aan").text('AAN');
	 }
	else {
		$(".aan").text('UIT');
		$('.adv-slide-checkbox').addClass('opened');
		}
  });
</script>
                                                    <?php echo $form->checkBox($model,'check', 
                                                            array(
                                                                'name' => 'check',
                                                                'value'=>"None",
                                                                'onchange'=> "",
                                                                'style' =>'display:none', 
                                                                'id' => 'slideThree', 
																'class' => 'ena'
                                                                )
                                                            ); ?>
                                                        <label for="slideThree"></label>
                                                </div>
                                                <div class="adv-on-off">
                                                        <span>BIEDEN:</span>
                                                        <span class="aan">AAN</span>
                                                </div>
                                        </div>
                                </div>
                                <div class="bieden-content">
                                        <h5>Geef hier aan hoeveel het minimum bod moet bedragen.</h5>
                                        <?php echo $form->textField($model,'bid',
                                                                    array('size'=>10,'maxlength'=>10,'class'=>"form-control",'placeholder'=>"€ 500,-")); ?>
                                        <?php  echo $form->error($model,'bid'); ?>
                                </div>	
                        </div>
                </div>				
        </div>
         
        <div class="row">
                <div class="col-md-6 col-xs-12 adv-place">
                        <h2>Plaats de advertentie</h2>
                        
                        <?php
                            if(Yii::app()->controller->action->id != 'create')
                                    $this->renderPartial('//users/_formRegister',array('form' => $form,'model' => $users,'not_logined'=>1)); 
                            
                            echo CHtml::submitButton('PLAATSEN', array('class' =>'btn btn-primary')); 
                            if(Yii::app()->controller->action->id == 'update'){ 
                                echo CHtml::button('VERWIJDEREN', array('id' => 'delete-announcement','onclick' => 'deleteAnn(this)' ,'class' =>'btn btn-primary','data-submit' => Yii::app()->createUrl('announcement/delete',array('id' =>$model->id)))); 
                        
                            } ?>
                </div>

                <div class="col-md-6 col-xs-12 adv-post-video">
                        <h2>Voeg een url of video toe</h2>
                        <p>
                                Dropbord bied u de mogelijkheid om een url en/of video bij uw 
                                advertentie te plaatsen. Op deze manier kunt u uw producten 
                                nog beter presenteren aan eventuele kopers.<br>
                                <strong>Het plaatsen van een advertentie met alleen foto’s en tekst 
                                        is gratis.
                                </strong>
                        </p>
                        
                        <div class="form-group">
                                <label>Plaats een website url bij uw advertentie(€3,75):</label>
                                <?php echo $form->textField($model,'site_url',array('class' =>'form-control' )); ?>
                        </div>
                        <div class="form-group paste-url">
                                <label>Plaats een video bij uw advertentie(€5,75):</label>
                                <?php echo $form->textField($model,'video_url',array('class' =>'form-control','placeholder'=>"plak hier uw youtube of vimeo url.." )); ?>
                                <span>Of</span>
                                <div class="form-group" style="display:none">
                                        <?php   echo $form->fileField($model, 'video'); ?>

                                </div>
								
								<div style="display:inline-block;">
                                <?php
                                    echo chtml::tag('button',array(
                                                                'class'=>'btn btn-primary',
                                                                //'onclick' => 'document.getelementbyid("announcement_video").click(); return false'
                                                        ),'kies een<br> bestand');
                                    
                                    ?>
									
									
								<div style="height: 30px; width: 100px; margin-top: -33px;">
								 <?php
                                if(isset($users->id))
                                    $imagePath = '/images/'.$users->id."/";
                                else {
                                    $imagePath = '/images/';
                                }
                                
                                $this->widget('MUploadify',array(									
                                    'model'=>$files,
                                    'fileObjName' => 'Files',
                                    'attribute'=>'video',
                                    'overrideEvents'=>array('onSelectError','onUploadError','onError','onUploadProgress'),
                                    'uploader' =>Yii::app()->createUrl('announcement/uploadVideo'), 
                                    'method'=>'post',
                                    'auto'=>'true',									
                                    //'hideButton'=>'true',,
                                    'buttonText'=>'',
                                    'wmode'=>'transparent',
                                    //'height'=>'80',
                                    'fileTypeExts'=>'*.mpeg4; *.wmv; *.mp4; *.3gp',
                                    'fileTypeDesc'=>'Video files',
                                    //'uploadLimit'  => 1,
                                    'fileSizeLimit' => '30MB',
                                    //'queueSizeLimit'  => 1,
                                    'multi'=>false,
                                    'onUploadStart' =>'js:function(file){											
                                            var formData = {"id":"'.$model->id.'" , "action":"'.Yii::app()->controller->action->id.'"};
                                            $("#Files_video").uploadify("settings", "formData", formData);
                                    }',                                   						
                                    'onSelectError' =>'js:function(file, errorCode, errorMsg, errorString){		
                                            //debugger;			
                                            alert("You have exceeded maximum limit");
                                    }',
                                    'onUploadError' =>'js:function(file, errorCode, errorMsg, errorString){					
                                            alert("The file " + file.name + " could not be uploaded: " + errorString);
                                    }',
                                    'onUploadProgress' =>'js:function( file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal){					                                            
                                                    var percent = Math.round((totalBytesUploaded / totalBytesTotal) * 100);
                                                    //$("#videoProgress_old").html("Percent: " + percent + "% : " + totalBytesUploaded + " bytes uploaded of " + totalBytesTotal + " bytes.");
                                                    $(".progress-bar").width(percent + "%");
                                                    $(".sr-only").html(percent + " % Loaded");
                                    }',
                                    'onError' =>'js:function(errorType){					
                                            alert("The error was: " + errorType);
                                    }',
                                    'onUploadSuccess' =>'js:function(file,data){
                                        var response = data.split("-");
                                        var innHtml;
                                        var id = response[0];
                                        var name = response[1];
                                        url = "'.$this->createUrl('announcement/deleteImages').'";
                                        
                                        input = "<input id=\"File_name\" class=\"form-control\" type=\"hidden\" name=\"File["+id+"][id]\" value=\""+id+"\" >";
                                        $(".photo-item-input").append(input);
                                        $("#Announcement_video_url").val(file.name);
                                        $(".paste-url").append("<input id=\"File_saved_name\" class=\"form-control\" type=\"hidden\" name=\"Announcement[video_hidden_name]\" value=\""+name+"\" >");
                                        
									}',
                                    
                                ));
								?>
                                  </div>
								  </div>  
								<!--<div id="videoProgress_old"></div>	-->
								<div class="progress">
								  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">								  
									<span class="sr-only"></span>
								  </div>
								</div>							
                </div>
				</div>
        </div>
        <?php $this->endWidget(); ?>
</div>
