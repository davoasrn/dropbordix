<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <a href="" class="item-close">&nbsp;</a>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Wij zoeken voor u</h5>
                                word op de hoogte gebracht van nieuwe advertenties
                                <div class="success-register" style="font-size: 25px;color: #ff7921"></div>
                        </div>
                        <?php
                      $action='search/valid';
                      $url='search/searchMe';
         $form=$this->beginWidget('CActiveForm', array(
		'id'=>'announcement-create-form',
                'action' => Yii::app()->createUrl($action),
		'enableAjaxValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=> true,
                    'afterValidate' =>'js:function(form,data,hasError){
                        if(!hasError){
                            $.ajax({
                                "type" : "POST",
                                "url"  : "'.Yii::app()->createUrl($url).'",
                                "data" : form.serialize(),
                                "success" : function(data) {
                                var json = JSON.parse(data);
                                if(json.status=="saved"){

                                    
                                    console.log(url);
                                    navigationToView(url);
                                } 
                            }
                            });
                        }
                    }'
                )
    )); ?>
               <h3>E-mail adres</h3>
                <div class="form-group">
                        <?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'Email ...')); ?>
                        <?php echo $form->error($model,'email'); ?>
                </div>
    
                <i class="orange">*</i>
                 <br />

                 <h3>Trefwoorden vul minimaal 1 veld in</h3>
                <div >
                       
                        <?php echo $form->textField($model,'trefwoord1',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'Trefwoord 1')); ?>
                        <?php echo $form->error($model,'trefwoord1'); ?>
                </div><br />
                    <div >
                       
                        <?php echo $form->textField($model,'trefwoord2',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'trefwoord 2')); ?>
                        <?php echo $form->error($model,'trefwoord2'); ?>
                    </div><br />
                    <div >
                        
                        <?php echo $form->textField($model,'trefwoord3',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'trefwoord 3')); ?>
                        <?php echo $form->error($model,'trefwoord3'); ?>
                    </div><br />
                      <div >
                       
                        <?php echo $form->textField($model,'trefwoord4',array('size'=>60,'maxlength'=>255,'class'=>"form-control searchMe",'placeholder'=> 'trefwoord 4 ')); ?>
                        <?php echo $form->error($model,'trefwoord4'); ?>
                    </div><br />
    
                    <h3>Postcode binnen welke straal zoeken wij voor u?</h3>
                    <table>
                    <tr>
                    <td>
                    
                     <div >
                       
                        <?php echo $form->textField($model,'zipcode',array('size'=>20,'maxlength'=>6,'class'=>"form-control searchMe",'placeholder'=> '1234 XX')); ?>
                        <?php echo $form->error($model,'zipcode'); ?>
                      </div>
                     </td>
                    <td>
                    
                    	<?php 
                        $array=array(10=>'10 km', 20=>'20 km',50=>'50 km',100=>'100 km',1000=>'1000 km');
                        echo $form->dropDownList($model,'range', 
                                    $array,array('class'=>"form-control contact",'placeholder'=>"selecteren...")
                                    
                                    ); ?>
                                     <?php echo $form->error($model,'range'); ?>
                          </td></tr> </table><br/><br />
    <?php echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary'),'Versturen'); ?>
    
        <?php $this->endWidget(); ?>
        </div>
        <div class="col-md-6 adv-photo-container">
                        <div class="edit-profile-title">
                                <h5>Hoe werkt zoeken voor mij?</h5>
                                
                        </div>
    
    <h4>
       <b> Wij houden u op de hoogte van advertenties waar u naar opzoek bent, komen de trefwoorden<br/>
        overeen dan ontvangt u een e-mail met een overzicht van de advertenties die u zoekt.</b>
    </h4>
    </div>
    
    
    
    
    </div>
</div>


            <script>
            function searchMe()
            {
                var email;
               var data=$("#useSearchMe").serialize();
               email=$("#use_mail").val();
               if(email==null || email.trim()=="")
               {
                alert( "Vul in het zoekveld ");
               }
               else{
                
                    $.ajax({
                
                	   'type':'post',
                	   //'url' : '<?php echo Yii::app()->createUrl("Saerch/searchMe") ?>',
                	   'data' : data,
                        beforeSend : function (){
                            alert(data);
                           if(data==null || data.trim()=="") 
                           {
                            alert(adatarke);
                           }
                            
                        },
                	  
                      success: function(data) {
                         var Odata = $.parseJSON(data);
                               //console.log(Odata)
                             
                                
                            },
                        })
                }
            }
               </script>
