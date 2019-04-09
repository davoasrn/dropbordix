<?php $this->layout = false; ?>
<div>
<p>Beste gebruiker </p><br />

U heeft zojuist en bod van € <?php echo $model->sum; ?>,- uitgebracht op de advertentie : <?php echo CHtml::link('show announcement', Yii::app()->createUrl('announcement/show',array('id' =>$model->announcement->id))); ?> <br />

Bekijk ook andere advertenties op <?php echo CHtml::link('dropbord.nl', Yii::app()->homeUrl); ?><br>

Met vriendelijke groeten, <br />

Team Dropbord.nl  <br />

www.dropbord.nl <br />

ADVERTENTIE <br />

Titel: <?php echo $model->announcement->name ?> <br />

Link naar advertentie: <?php echo CHtml::link('show announcement', Yii::app()->createUrl('announcement/show',array('id' =>$model->announcement->id))); ?> <br />

Prijs: Gereserveerd  <br />

Rubriek: <?php echo $model->announcement->category->name; ?>  <br />

Datum van plaatsing: <?php echo $model->announcement->change_date; ?>  <br />

Er zijn op alle grote marktplaatsen, dus ook op Dropbord.nl oplichters aanwezig. 
 <br />
Wees extra argwanend bij Engelse reacties of reacties in slecht Nederlands.
 <br />
Als u te maken hebt met een fraudeur, neem dan a.u.b. contact met ons op en  <br />

vermeld het emailadres van de oplichter. <br />

Contact opnemen via: www.dropbord.nl/comtact <br />
</div>