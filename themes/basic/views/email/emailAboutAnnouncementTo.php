<?php $this->layout = false; ?>
<div>
<p>Beste gebruiker </p><br />

Bekijk ook andere advertenties op <?php echo CHtml::link('dropbord.nl', Yii::app()->params['siteUrl']); ?><br>

Met vriendelijke groeten, <br />

Team Dropbord.nl  <br />

www.dropbord.nl <br />

ADVERTENTIE <br />

Titel: <?php echo $model->name ?> <br />

Link naar advertentie: <?php echo CHtml::link('show announcement', Yii::app()->params['siteUrl'].Yii::app()->createUrl('site/show',array('id' =>$model->id))); ?> <br />

Prijs: <?php echo $model->libStatus->name; ?>  <br />

Rubriek: <?php echo $model->category->name; ?>  <br />

Datum van plaatsing: <?php echo $model->change_date; ?>  <br />

Er zijn op alle grote marktplaatsen, dus ook op Dropbord.nl oplichters aanwezig. 
 <br />
Wees extra argwanend bij Engelse reacties of reacties in slecht Nederlands.
 <br />
Als u te maken hebt met een fraudeur, neem dan a.u.b. contact met ons op en  <br />

vermeld het emailadres van de oplichter. <br />

Contact opnemen via: www.dropbord.nl/contact <br />
<?php echo (isset($sendModel->phone) && !empty($sendModel->phone)) ? "Telefoonnummer :  ".$sendModel->phone."<br />" : ""; ?>
<?php echo (isset($sendModel->role) && !empty($sendModel->role)) ? "Organization :  ".($sendModel->role == 1) ? "Bedrijven": "Particulier" ."<br />" : ""; ?>
<?php echo (isset($sendModel->comments) && !empty($sendModel->comments)) ? "Comment :  ".$sendModel->comments."<br />" : ""; ?>
</div>