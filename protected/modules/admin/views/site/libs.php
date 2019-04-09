<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' Libs';
$this->breadcrumbs=array(
	'Libs',
);
?>

<h1>Libs</h1>

<?php 
$i = 1;
foreach ($libs as $modelName => $libName){
    echo $i.". ";
    echo CHtml::Link($libName,array("/admin/".$modelName));
    echo '<br />';
    $i++;
}
?>