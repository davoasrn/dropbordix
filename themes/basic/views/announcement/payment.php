<div class="bieden-wrapper">
        <p>
            <?php echo CHtml::link('Bekijk op Google maps', 'https://www.google.com.au/maps/preview/@-15.623037,18.388672') ?>
            
        </p>
        <div class="adv-bieden-container">
                <div class="bieden-title">
                        <h4>BIEDEN</h4>
                        <!-- Slide THREE -->

                </div>
                <div class="bieden-content">
                        <div class="form-group">
                                <label>E-mail adres:</label>
                                <input type="text" class="form-control" placeholder="E-mail adres..">
                                <?php echo $form->textField($model,'name',array('placeholder'=>"Seat Ibiza 1.6 SE 1998",'class'=>"form-control")); ?>
                                <?php echo $form->error($model,'name'); ?>
                        </div>
                        <div class="form-group">
                                <label>Uw bod (boven €3000,-):</label>
                                <input type="text" class="form-control" placeholder="€">
                        </div>
                        <div class="form-group">
                                <button class="btn btn-primary">Plaats uw bod</button>
                        </div>
                </div>
                <div class="bieden-list">
                        <ul>
                                <li>Sipke1991@live.nl <span>€3000,-</span></li>
                                <li>Sipke1991@live.nl <span>€2500,-</span></li>
                                <li>Marcopoppinga@lho...<span>€2000,-</span></li>
                                <li>Bart-hoekstra@live.nl <span>€1500,-</span></li>
                        </ul>
                </div>	
        </div>
</div>