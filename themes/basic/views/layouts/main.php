<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/custom.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.fancybox.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.fancybox-thumbs.css?v=1.0.7" />
        
<!--	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/lightbox.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
        
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		
		<?php // Yii::app()->clientscript->scriptMap['jquery.js'] = false; ?>
        <!--<script src="//localhost:35729/livereload.js"></script>-->
    </head>
    <body>

            <header>
                <div class="container header-container">
                    <div class="header-logo-wrapper"><a href="<?php echo Yii::app()->homeUrl; ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/logo.png"></a></div>
                    <div class="navbar-toggle-container">
                        <a href="" id="navbar-toggle-btn">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="header-navbar header-loggedin-navbar">
      <?php
    $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/loginSocial'));
    ?>
						<?php
                                                if(!is_null(Yii::app()->user->getState('type')) && Yii::app()->user->getState('type') == 3)
                                                    $photo = Yii::app()->user->getState('photo') ;
                                                elseif (!is_null(Yii::app()->user->getState('photo')) && Yii::app()->user->getState('photo') != "") {
                                                    $photo = '/images/'.Yii::app()->user->getId()."/".Yii::app()->user->getState('photo');
                                                }  else {
                                                    $photo = Yii::app()->theme->baseUrl.'/img/user-img.png';
                                                }
                                                $categories = CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id' => 0)),'id','countAndName');
                                                $div = '';
                                                $div1 = '';
                                                foreach ($categories as $countCat => $cat){
                                                    $classCurrent = (isset($_GET['id']) && $countCat == $_GET['id']) ? 'class = "current"' : NULL;
                                                    if($countCat%2 == 0){
                                                        $div .= '<li '.$classCurrent.'><p>'.CHtml::link($cat, array('site/list','id'=>$countCat,'is_widget' => 0)).'</p></li><br>';
                                                    }else{
                                                        $div1 .= '<li '.$classCurrent.'><p>'.CHtml::link($cat, array('site/list','id'=>$countCat,'is_widget' => 0)).'</p></li>';
                                                    }
                                                }
                                                
						$this->widget('zii.widgets.CMenu', array(
								'id'=>false,
								'encodeLabel' => false,
								'htmlOptions'=>false,
								'encodeLabel'=>false, 
								'items'=>array(
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<i class="fa fa-thumb-tack"></i>
													</div> 
													<div class="navbar-list-title-wrapper">
														PLAATSEN <span>Advertentie plaatsen</span>
													</div>',
										'url'=>'#',
										'itemOptions'=>array('class'=>'plaatsen'),
										'linkOptions'=>array(
                                                                                                'onclick' => 'js:navigation(this)',
                                                                                                'data-href' => is_null(Yii::app()->user->getId()) 
                                                                                                               ? Yii::app()->createUrl('announcement/createNotLogined') 
                                                                                                               : Yii::app()->createUrl('announcement/create')
                                                                                                ),
									),
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<i class="fa fa-search"></i>
													</div> 
													<div class="navbar-list-title-wrapper">
														ZOEK VOOR MIJ<span>Houd mij op de hoogte</span>
													</div>',
										'url'=>'#',
										'itemOptions'=>array('class'=>''),
										'linkOptions'=>array('onclick' => 'js:navigation(this)','data-href' => Yii::app()->createUrl('searchMe/create')),
									),
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<i class="fa fa-bars"></i>
													</div> 
													<div class="navbar-list-title-wrapper">
														RUBRIEKEN <span>Blader door rubrieken</span>
													</div>
													<div class="dropdown-menu v2" style="margin-top:0;">
                                                                                                            <div class="dropdown-menu-col">
                                                                                                                <ul>'.
                                                                                                                    $div
                                                                                                                .'</ul>
                                                                                                                
                                                                                                            </div>
                                                                                                            <div class="dropdown-menu-col">
                                                                                                                <ul>'.
                                                                                                                    $div1
                                                                                                                .'</ul>
                                                                                                                
                                                                                                            </div>
                                                                                                        </div>',
										'url'=> '#',// Yii::app()->createUrl('site/categoryesList'),
										'linkOptions'=>array('data-toggle' => 'dropdown'),
										'itemOptions'=>array('class'=>'subheader-dropdown dropdown'),
									),
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<i class="fa fa-envelope"></i>
													</div> 
													<div class="navbar-list-title-wrapper">
														CONTACT <span>Vragen en opmerkingen</span>
													</div>',
										'url'=>'#',
										'itemOptions'=>array('class'=>''),
										'linkOptions'=>array('onclick' => 'js:navigation(this)','data-href' => Yii::app()->createUrl('site/contact')),
									),
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<img style="width:40px;height:40px" src="'.$photo.'">
													</div> 
													<div class="navbar-list-title-wrapper">
														'.Yii::app()->user->getState('name').' <span>Bewerk uw profiel</span>
													</div>',
										'url'=>'#',
										'itemOptions'=>array('class'=>''),
										'linkOptions'=>array('onclick' => 'js:navigation(this)','data-href' =>  Yii::app()->createUrl('users/update',array('id' =>Yii::app()->user->getId()))),
										'visible' => is_null(Yii::app()->user->getId()) ? false : true
									),									
									array(
										'label'=>'	<div class="navbar-icon-wrapper">
														<i class="fa fa-user"></i>
													</div> 
													<div class="navbar-list-title-wrapper">
														INLOGGEN <span>Klik om in te loggen</span>
													</div>',
										'url'=>'#',
										'itemOptions'=>array('class'=>''),
										'linkOptions'=>array('onclick' => 'js:navigation(this)','data-href' => Yii::app()->createUrl('site/login')),
										'visible' => is_null(Yii::app()->user->getId()) ? true : false
									),									
								),
							));
						?>
					<!--
                        <ul>
                            <li>
                                <a href="">
                                    <div class="navbar-icon-wrapper"><i class="fa fa-thumb-tack"></i></div> <div class="navbar-list-title-wrapper">DROPID <span>Advertentie platseen</span></div>
                                </a>
                            </li>
                             <li>
                                <a href="">
                                    <div class="navbar-icon-wrapper"><i class="fa fa-search"></i></div> <div class="navbar-list-title-wrapper">ZOEK VOOR MIJ<span>Houd mij op de hoogte</span></div>
                                </a>
                            </li>
                             <li>
                               <a href="">
                                    <div class="navbar-icon-wrapper"><i class="fa fa-bars"></i></div> <div class="navbar-list-title-wrapper">RUBRIEKEN <span>Blader door rubrieken</span></div>
                                </a>
                            </li>
                             <li>
                               <a href="">
                                    <div class="navbar-icon-wrapper"><i class="fa fa-envelope"></i></div> <div class="navbar-list-title-wrapper">CONTACT <span>Vragen en opmerkingen</span></div>
                                </a>
                            </li>
							<?php // if(Yii::app()->user->getId()){ ?>
								<li>
									<a href="">
										<div class="navbar-icon-wrapper"><img src="<?php // echo Yii::app()->theme->baseUrl; ?>/img/avatar-img.png"></div> <div class="navbar-list-title-wrapper"><?php echo Yii::app()->user->getState('name'); ?> <span>Bewerk uw profiel</span></div>
									</a>
								</li>
							<?php // }else{ ?>
								<li>
								   <a href="" data-href="site/login">
										<div class="navbar-icon-wrapper"><i class="fa fa-user"></i></div> <div class="navbar-list-title-wrapper">INLOGGEN <span>Klik om in te loggen</span></div>
									</a>
								</li>
							<?php // } ?>
                        </ul> -->
                    </div>
                </div>
                <div class="container-fluid header-secondary-container-wrapper" >
                    <div class="container header-secondary-container">
                        <div class="header-secondary-info pull-left">
                            <div class="header-secondary-icon-wrapper"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/pin.png"></div>
                            <h6>REGIO FRIESLAND <br>8508 RG <i class="fa fa-chevron-left"></i> 50KM</h6>
                        </div>
                        <?php if(!is_null(Yii::app()->user->getId())){ ?>
                        <div class="subheader-dropdown dropdown">
                            <a href="" data-toggle="dropdown">VOEG EEN <br class="visible-xs"> WIDGET TOE <i class="fa fa-chevron-right"></i></a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-col">
                                    <h3 class="col-title">WIDGETS BEHEREN</h3>
                                    <ul>
                                        <?php 
                                        $widgets = LibWidgets::model()->findAll(); 
                                        foreach ($widgets as $widget){
                                        ?>
                                        <li id="<?php echo "widget-".$widget->id."-0"; ?>">
                                            <h4><?php echo strtoupper($widget->name); ?></h4>
                                            <p><?php echo $widget->description; ?></p>
                                            <?php
                                            echo CHtml::link('<span class="icon"></span>Verwijder','#',
                                                                array(
                                                                                'onclick' => 'js:widgetOperations(this)',
                                                                                "data-status" => '0',
                                                                                'data-href' => Yii::app()->createUrl('site/widget'),
                                                                                'data-id' => $widget->id,
                                                                                'class' => 'remov-item'
                                                                        )
                                                                );
                                            ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="dropdown-menu-col">
                                    <h3 class="col-title">WIDGETS BEHEREN</h3>
                                    <ul>
                                        <?php 
                                        $widgets = LibWidgets::model()->findAll(); 
                                        foreach ($widgets as $widget){
                                        ?>
                                        <li id="<?php echo "widget-".$widget->id."-1"; ?>">
                                            <h4><?php echo strtoupper($widget->name); ?></h4>
                                            <p><?php echo $widget->description; ?></p>
                                            <?php
                                            echo CHtml::link('<span class="icon"></span><br> Voeg toe','#',
                                                                        array(
                                                                                    'onclick' => 'js:widgetOperations(this)',
                                                                                    "data-status" => '1',
                                                                                    'data-href' => Yii::app()->createUrl('site/widget'),
                                                                                    'data-id' => $widget->id,
                                                                                    'class' => 'add-item'
                                                                                )
                                                                );
                                            ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="header-secondary-form pull-right">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'search',
                            'enableAjaxValidation'=>false,
                                'htmlOptions'=>array(
                                                       'onsubmit'=>"return false;",/* Disable normal form submit */
                                                       'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                                                     ),
                        )); ?>

                            <form id="search" class="form-horizontal" method="POST">
                                <div class="form-inner">
                                
                                 <input type="text" id="keyword" name="keyword" onkeyup="suggest(this.value);"  class="form-control" placeholder="Zoeken op trefwoord..."/>  <!--onblur="fill();fillId();"-->
                                 <div class="suggestionsBox"  id="suggestions" style="display: none;">
                                  <div class="suggestionList"  id="suggestionsList"> &nbsp; </div>
                                    
                                </div>
                               
                                <input type="hidden" name="keyword_hidden" id="keyword_hidden" value="" />
                                </div>
                               
                                <div class="form-inner styled-select">
                                
                                    <?php echo CHtml::dropdownlist('category', '<selected value>', CHtml::listData(LibCategory::model()->findAllByAttributes(array('parent_id'=>0)),'id','name'),
                                    array('class'=>'form-control','empty'=>'Rubrieken...')
                                    );?>
                                  
                                </div>
                                <div class="form-inner">
                                    <input type="text" name="zipcode" class="form-control short-input"placeholder="8508 RG...">
                                </div>
                                <div class="form-inner styled-select">
                                     <select class="form-control" name="range">
                                        <option value="10">10 km</option>
                                            <option value="20">20 km</option>
                                            <option value="50">50 km</option>
                                            <option  value="100">100 km</option>
                                            <option  value="100000">geen voorkeur</option>
                                        
                                    </select>
                                </div>
                                <div class="form-inner ">
                               
 
                                     <a id="send" onclick="send();" >Zoeken <i class="fa fa-search"></i></a>
                                    
                                         
                                  
                                </div>
                            </form>
                            <?php $this->endWidget(); ?>
                           <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>-->
            <script type="text/javascript">
             
                        function send()
                         {
                         
                           var data=$("#search").serialize();
                        // console.log(data);
                         
                         
                          $.ajax({
                            type: 'POST',
                            url: '<?php echo Yii::app()->createAbsoluteUrl("site/search"); ?>',
                            data:data,
                            success :function(data) {
                                     $(".search").remove();
                                     $(".home-items-container .top").after(data);
                                     setupBlocks();
                                    positionBlocks($('.home-items-container > .home-item'));
                             },
                           error: function(data) { 
                                 alert("Error occured.please try again");
                                 //alert(data);
                            },
                         
                          dataType:'html'
                          });
                         
                        }
                        
                        
                     function suggest(inputString){ 
                            if(inputString.length == 0) {
                            $('#suggestions').fadeOut();
                            } else {
                            $.ajax({
                            url: '<?php echo Yii::app()->createAbsoluteUrl("site/suggest"); ?>',
                           data: 'queryString='+inputString,
                            success: function(msg){
                                
                            if(msg.length >9) {
                                $('#keyword').addClass('load');
                            $('#suggestions').fadeIn();
                            $('#suggestionsList').html(msg);
                            $('#suggestionsList').css("border", "1px solid black");
                             $('.suggestionsBox').css("left",$("#keyword").position().left);
                            $('#keyword').removeClass('load');
                                                        
                            }
                            else{
                                $('#suggestions').fadeOut();
                                $('#suggestionsList').html(inputString);
                                //alert(inputString);
                                $('#keyword').val(inputString);
                                 $('#keyword').text(inputString);
                                 document.getElementById('keyword').value = inputString;

                            }
                            }
                            });
                            }
                            }
                            function fill(thisValue) {
                            $('#keyword').val(thisValue);
                            setTimeout("$('#suggestions').fadeOut();", 600);
                            }
                            function fillId(thisValue) {
                            $('#keyword_hidden').val(thisValue);
                            setTimeout("$('#suggestions').fadeOut();", 600);
                            }

                         
                        </script>
                        <style>
                       
                         #result {
                                	height:20px;
                                	font-size:16px;
                                	font-family:Arial, Helvetica, sans-serif;
                                	color:#333;
                                	padding:5px;
                                	margin-bottom:10px;
                                	background-color:#FFFF99;
                                }
                                #keyword{
                                	padding:3px;
                                	border:1px #CCC solid;
                                	font-size:17px;
                                }
                                .suggestionsBox {
                                	position: absolute;
                                	
                                	top:80px;
                                	margin: 26px 0px 0px 0px;
                                	width: 190px;
                                	padding:0px;
                                	background-color: #ff6805;
                                	border-top: 3px solid #ff6805;
                                	color: #fff;
                                     z-index: 3;
                                }
                                .suggestionList {
                                	margin: 0px;
                                	padding: 0px;
                                }
                                .suggestionList ul li {
                                	list-style:none;
                                	margin: 0px;
                                	padding: 6px;
                                	border-bottom:1px dotted #666;
                                	cursor: pointer;
                                }
                                .suggestionList ul li:hover {
                                	background-color: #FC3;
                                	color:#ff6805;
                                }
                                ul {
                                	font-family:Arial, Helvetica, sans-serif;
                                	font-size:11px;
                                	color:#FFF;
                                	padding:0;
                                	margin:0;
                                }
                                
                                .load{
                                background-image:url(loader.gif);
                                background-position:right;
                                background-repeat:no-repeat;
                                }
                                
                                #suggest {
                                	position:relative;
                                }

                        </style>
                        </div>
                    </div>
                </div>
            </header>

	<div class="container main-container home-container">
		<?php echo $content; ?>
	</div>

	<div class="bg-overlay">
                
		<div class="modal-content-wrapper">
			
		</div>
<!--		<div class="loading" style="display: block;">-->
		</div>		
	</div>

	<footer>
        <div class="container footer-container">
           
            
            
            
            
            
            
            <?php
            
            
            
            $menu_cats=new MenuCat;
            
            
            
            
            $menus=$menu_cats->findAll();
            
            
        foreach($menus as $menu){
            
            
            
            echo "  <ul>
                <li><h6>".$menu->cat_name."</h6><ul>";
                   
            
            $pages= Yii::app()->db->createCommand("select menu.*,content.*,content.id as pid from `menu` LEFT JOIN `content` ON `menu`.`page_id`=`content`.`id`  WHERE `cat_id` ='$menu->id' AND `content`.`is_published`='1' ")->queryAll();
            
           
            if($pages!==false){
            
            foreach($pages as $page){
           
                
      echo ' <li><a href="'.Yii::app()->getBaseUrl(true).'/index.php?r=/content/default/show&page_id='.$page['pid'].'">'.$page['page_title'].'</a></li>';    
                
                
            }
            }
            
            
                 
                        echo' 

 </ul>
        </li>  </ul>
            

';
       
            
            
            
            
            
            
        }
        
        
        
        
        
        
        
        
        
            
            ?>
            
       
        
        
      
            
            
           
        </div>
	</footer>


<!--	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
    <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/jquery.fancybox.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<!--    <script src="<?php // echo Yii::app()->theme->baseUrl; ?>/js/vendor/lightbox.min.js"></script>-->
    
<!--    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>-->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/masonry.pkgd.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/imagesloaded.pkgd.min.js"></script>

    <!-- Main js file -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>       

    <!-- Page specific js files -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/home.js"></script>
        
    </body>
</html>