    <!---- Start Right sidebar ---->
    <div class="wfps_setting_right">
        <div class="wfps_setting_right_rocket">
            <img src="<?php echo SAMPLY_ASSETS . '/img/wfps-rocket.png'?>" alt="Samply">
            <br>
            <?php if( class_exists('Woo_Free_Product_Sample_Pro') ) { ?>
                <a class="wfpe_button" href="https://www.thenextwp.co/account/" target="_blank"><?php echo __('Manage License', 'samply'); ?></a>
            <?php } else { ?>
                <a class="wfpe_button" href="https://www.thenextwp.co/downloads/free-product-sample-for-woocommerce/" target="_blank"><?php echo __('Upgrade to Pro', 'samply'); ?></a>
            <?php } ?>                
        </div>
    </div>
    <!---- End Right sidebar ---->