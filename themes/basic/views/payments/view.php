<div class="bieden-list">
        <ul>
            <?php foreach ($payments as $payment){ ?>
                <li><?php echo CHtml::encode($payment->email); ?> <span><?php echo "€".CHtml::encode($payment->sum).",-"; ?></span></li>
            <?php } ?>
        </ul>
</div>	