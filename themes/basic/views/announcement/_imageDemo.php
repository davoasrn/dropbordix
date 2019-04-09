<div class="add-photo-container ">
	<div class="click-photo-wrapper ">
                <div class="click-photo" style="background-size:cover;text-align:center;">						
                        <div style="margin: 110px auto;display:inline-block;">
<?php

                            if(isset($user->id))
                                $imagePath = '/images/'.$user->id."/";
                            else {
                                $imagePath = '/images/';
                            }		
                            $this->widget('MUploadify',array(
                                'model'=>$model,
                                            'fileObjName' => 'Files',
                                            'attribute'=>'photo',
                                            'overrideEvents'=>array('onSelectError','onUploadError','onError'),
                                            //'name' => 'photo',
                                //'uploader' =>array('announcement/upload'), 
                                            'uploader' =>Yii::app()->createUrl('announcement/upload'), 
                                //'scriptData' => array(
                                //    'id'=>$announcement->id,
                                 //   'action' => Yii::app()->controller->action->id
                                 //   ),
                                            'method'=>'post',
                                            'auto'=>'true',
                                            'hideButton'=>'true',
                                            'buttonText'=>'',
                                            'wmode'=>'transparent',
                                            'height'=>'80',
                                            'fileTypeExts'=>'*.gif; *.jpg; *.png; *.jpeg',
                                            'fileTypeDesc'=>'Image files',
                                            'uploadLimit'  => 15,
                                            'queueSizeLimit'  => 15,			
                                'multi'=>true,
                                //'script'=>$this->createUrl('announcement/upload',array('id'=>$announcement->id)),
                                            'onUploadStart' =>'js:function(file){
                                                    var formData = {"id":"'.$announcement->id.'" , "action":"'.Yii::app()->controller->action->id.'"};
                                                    $("#Files_photo").uploadify("settings", "formData", formData);
                                            }',                                            
                                            'onSelectError' =>'js:function(file, errorCode, errorMsg, errorString){		
                                                    //debugger;			
                                                    alert("You have exceeded maximum limit");
                                            }',
                                            'onUploadError' =>'js:function(file, errorCode, errorMsg, errorString){					
                                                    alert("The file " + file.name + " could not be uploaded: " + errorString);
                                            }',
                                            'onError' =>'js:function(errorType){					
                                                    alert("The error was: " + errorType);
                                            }',
                                            'onUploadSuccess' =>'js:function(file,data){
                                                    var response = data.split("-");
                                                    var id = response[0];
                                                    var name = response[1];
                                                    url = "'.$this->createUrl('announcement/deleteImages').'";

                                                    msg = "<div class=\"photo-item-wrapper\"><div class=\"item1\" style=\"background-image:url(\''.$imagePath.'"+name+"\')\" ><a href=\"#\" data-id=\""+id+"\" data-path=\"'.$imagePath.'"+name+"\" data-url=\""+url+"\" onclick=\"closeImage(this)\"><i class=\"fa fa-times\"></i><p>Klik om te verwijderen</p></a></div></div>";
                                                    input = "<input id=\"File_name\" class=\"form-control\" type=\"hidden\" name=\"File["+id+"][id]\" value=\""+id+"\" >";
                                                    $(".click-photo").css("background-image", "url(\''.$imagePath.'"+name+"\')");  
                                                                        $(".item-photos").append(msg);
                                                    $(".photo-item-input").append(input);					
                                                                        $(".item1").hover(function(){
                                                                                var bug_url = $(this).css("background-image").replace("/thumbs","");
                                                                                $(".click-photo").css("background-image",bug_url);
                                                                        });
                                                                        $(".item1").find("a").click(function(event){						
                                                                                event.stopImmediatePropagation();
                                                                                var selector = "input[value="+"\'"+name+"\'"+"]";
                                                                                $(".photo-item-input").find(selector).remove();
                                                                                $(this).parent().parent().remove();
                                                                                $(".click-photo").css("background-image","none");
                                                                        });
                                                }',
                                            'onUploadError' => 'js:function(evt,queueId,fileObj,errorObj){alert("Error: " + errorObj.type + "\nInfo: " + errorObj.info);}',
                              ));
        ?>
                        </div>	
                        <a href="#" style="position: absolute; top: 0; z-index: -1; margin: 110px auto;">
                                <i class="fa fa-plus"></i>
                                <p>
                                        Klik hier om een<br> 
                                        foto te plaatsen

                                </p>
                        </a>
						
                </div>
	</div>
	<div class="item-photos">
		<div class='photo-item-input'>
                    <?php
                    if(isset($uploadedFiles)){
                        foreach ($uploadedFiles as $file){ 
                            echo CHtml::hiddenField('File['.$file->id.'][id]', $file->id, array('class'=>'form-control'));
                        } 
                    }
                        ?>
		</div>
                <?php 
                if(isset($uploadedFiles)){
                        foreach ($uploadedFiles as $file){ ?>
                            <div class='photo-item-input'>
                                <div class="item1" style="background-image:url(<?php echo $imagePath."/".$file->name;  ?>)">
                                    <?php echo CHtml::link('<i class="fa fa-times"></i>
                                                            <p>Klik om te verwijderen</p>', '#',
                                            array(
                                                'onclick' => 'js:closeImage(this)',
                                                'data-path' => $imagePath.$file->name,
                                                'data-id' => $file->id,
                                                'data-url' => $this->createUrl('announcement/deleteImages')
                                            )) ?>
                                </div>
                            </div>
                        <?php }
                }
                ?>
                
	</div>
</div>