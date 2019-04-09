<?php
$omnikassa = LibOmnikassa::model()->findByAttributes(array('status' => 1));
if(isset($omnikassa) && !empty($omnikassa)){
    $url = Yii::app()->params['siteUrl'].Yii::app()->createUrl('payments/paymentReturn',array('id' =>$id,'type' => LibPaidServices::video));
    $oOmniKassa = new OmniKassa($omnikassa->status);
    $oOmniKassa->setMerchant($omnikassa->merchant_id);
    $oOmniKassa->setSecurityKey($omnikassa->security_key, $omnikassa->security_key_version);
    $oOmniKassa->setReportUrl($url); 
    $oOmniKassa->setReturnUrl($url); 
    $oOmniKassa->setOrderId(Yii::app()->params['payment']['orderId']); 
    $oOmniKassa->setAmount($omnikassa->video_price); 
    $oOmniKassa->setButton('Pay for video');

    // Stel de beschikbare betaalmethode(n) in voor de koper (indien ingesteld).
    if(isset(Yii::app()->params['payment']['paymentMethod']) && is_array(Yii::app()->params['payment']['paymentMethod']) 
            && sizeof(Yii::app()->params['payment']['paymentMethod']))
    {
            $oOmniKassa->setPaymentMethod(Yii::app()->params['payment']['paymentMethod']); 
    }
    echo $oOmniKassa->createForm();
}