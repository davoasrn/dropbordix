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
                      
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'useSearchMe',
    'enableClientValidation' => false,
        
        'action' =>'#',
		'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit'=> false,
            'afterValidate' =>'js:function(form,data,hasError){
                if(!hasError){
                    $.ajax({
                        "type" : "POST",
                       
                        "data" : form.serialize(),
                        "success" : function(data) {
                        var json = JSON.parse(data);
                        if(json.status=="saved"){
                            $.each(data, function(key, val) {
                                
                               $(".contact").text(""); 
                              
                               $(".edit-profile-title").focus();
                            });
                            //location.reload();
                            document.getElementById("register-form").reset();
                        } 
                    }
                    });
                }
            }'
        ),
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); 
  
    ?>
               <h3>E-mail adres</h3>
               
    <input name="email" class="form-control searchMe" id="email"  placeholder='E-mail' />
    <i class="orange">*</i>
    <br />

    <h3>Trefwoorden vul minimaal 1 veld in</h3>
    <input name="trefwoord1" class="form-control searchMe" placeholder= 'Trefwoord 1'  /><br />
    <input name="trefwoord2" class="form-control searchMe"  placeholder= 'Trefwoord 2' /><br />
    <input name="trefwoord3" class="form-control searchMe"  placeholder= 'Trefwoord 3' /><br />
    <input name="trefwoord4" class="form-control searchMe"  placeholder= 'Trefwoord 4' /><br/>
    <h3>Postcode binnen welke straal zoeken wij voor u?</h3>
    <input maxlength="6" name="zipcode" class="form-postcode"  placeholder= '1234 XX' />
    
    <select  name="range" class="form-dropdown">
        <option    value="10">10 km</option>
        <option 	value="20">20 km</option>
        <option  value="50">50 km</option>
        <option value="100">100 km</option>
        <option  value="100000">geen voorkeur</option>
    </select><br/><br />
    <?php echo CHtml::tag('button', array('type'=>'submit', 'class'=>'bnt btn-primary','onClick'=>'searchMe()'),'Versturen'); ?>
    
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
                	   //'url' : '<?php echo Yii::app()->createUrl("Site/searchMe") ?>',
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
