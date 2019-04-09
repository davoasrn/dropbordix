<div class="modal-page adv-change-panel">
        <div class="item-close-wrapper">
                <span></span>
                <a href="#" class="item-close">&nbsp;</a>
        </div>

        <div class="row">
                <div class="col-md-6 edit-profile">
                        <div class="edit-profile-title">
                                <h5>Profiel bewerken</h5>
                                Bewerk uw gegevens
                        </div>
                        <div class="edit-profile-form-container">
                                <form>
                                        <div class="form-group">
                                                <label>Uw naam op Dropbord.nl</label>
                                                <input type="text" class="form-control">
                                                <span>*</span>
                                        </div>
                                        <div class="form-group">
                                                <label>Emailadres:</label>
                                                <input type="text" class="form-control">
                                                <span>*</span>
                                        </div>
                                        <div class="form-group postcode-wrapper">
                                                <label>Postcode:</label>
                                                <input type="text" class="form-control" placeholder="0000">
                                                <input type="text" class="form-control" placeholder="AB">
                                                <span>*</span>
                                        </div>
                                        <div class="form-group tel-number">
                                                <label>Telefoonnummer</label>
                                                <input type="text" class="form-control">
                                                <span>Optioneel</span>
                                        </div>
                                        <div class="form-group">
                                                <label>Wachtwoord:</label>
                                                <input type="password" class="form-control" placeholder="Wachtwoord...">							
                                        </div>
                                        <div class="form-group">
                                                <label>Herhaal wachtwoord:</label>
                                                <input type="password" class="form-control" placeholder="Wachtwoord...">							
                                        </div>
                                </form>
                        </div>
                        <div class="edit-btn-wrapper">
                                <button class="btn btn-primary">Opslaan</button>
                                <span>Wijzigingen opslaan</span>
                        </div>
                </div>


                <div class="col-md-6 adv-photo-container">
                        <div class="edit-profile-title">
                                <h5>Bewerk uw foto</h5>
                                Upload een nieuwe foto
                        </div>
                        <div class="upload-photo">
                                <div class="user-img-wrapper">
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/user-img.png">
                                </div>
                                <button class="btn btn-primary">Upload</button>

                        </div>
                </div>
        </div>
</div>
