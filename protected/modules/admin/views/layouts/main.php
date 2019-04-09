<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
        <script>window.jQuery || document.write('<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
        <?php
        $urlScript = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin').'/js/custom.js');
        Yii::app()->clientScript->registerScriptFile($urlScript, CClientScript::POS_HEAD);
        ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/menu.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array(
                                    'label'=>'Announcement', 
                                    'url'=>array('/admin/announcement/index'),
                                    'visible'=>!Yii::app()->user->isGuest
                                    ),
                                array(
                                    'label'=>'Libs',
                                    'url'=>array('/admin/site/libs'),
                                    'linkOptions'=>array('id'=>'menuLibs'),
                                    'itemOptions'=>array('id'=>'itemLibs'),
                                    'items'=>array(
                                      array('label'=>'Fuel Types', 'url'=>array('libFuelTypes/')),
                                      array('label'=>'Transmission', 'url'=>array('libTransmission/')),
                                            array('label'=>'Menu Cats', 'url'=>array('menuCat/')),
                                      array('label'=>'Category Types', 'url'=>array('libTypes/')),
                                    ),
                                    'visible'=>!Yii::app()->user->isGuest
                                  ),
                            
                            
                            array(
                                    'label'=>'Menu Categories',
                                    'url'=>array('/admin/menuCat')),
                            
                            
                            array(
                                    'label'=>'Menu',
                                    'url'=>array('/admin/Menu')),
                            
                            
                            array(
                                    'label'=>'Content',
                                    'url'=>array('/admin/Content')),
				array(
                                    'label'=>'Users',
                                    'url'=>array('/admin/users/'),
                                    'visible'=>!Yii::app()->user->isGuest
                                    ),
				array(
                                    'label'=>'Login',
                                    'url'=>array('/admin/site/login'),
                                    'visible'=>Yii::app()->user->isGuest
                                    ),
                                array(
                                    'label'=>'Site',
                                    'url'=>array('/'),
                                    'linkOptions' =>array('target' =>'_blank')
                                    ),
				array(
                                    'label'=>'Logout ('.Yii::app()->user->getState('name').')', 
                                    'url'=>array('/admin/site/logout'), 
                                    'visible'=>!Yii::app()->user->isGuest
                                    )
				
                            
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
