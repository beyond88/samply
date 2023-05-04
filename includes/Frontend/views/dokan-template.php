<div class="dokan-other-options dokan-edit-row dokan-clearfix <?php echo esc_attr( $class ); ?>">
    <div class="dokan-section-heading" data-togglehandler="dokan_other_options">
        <h2><i class="fa fa-cog" aria-hidden="true"></i> <?php esc_html_e( 'Product Sample', 'samply' ); ?></h2>
        <p><?php esc_html_e( 'Set your product sample options', 'samply' ); ?></p>
        <a href="#" class="dokan-section-toggle">
            <i class="fa fa-sort-desc fa-flip-vertical" aria-hidden="true"></i>
        </a>
        <div class="dokan-clearfix"></div>
    </div>

    <div class="dokan-section-content">

        <div class="dokan-form-group content-half-part">
            <?php $_enable_stock = ( $post->samply_manage_stock == '1' ) ? '1' : ''; ?>
            <input name="samply_manage_stock" id="samply_manage_stock" value="1" type="checkbox" <?php checked( $_enable_stock, 1 ); ?>>
            <?php esc_html_e( 'Enable manage stock', 'samply' ); ?>            
        </div>  

        <div class="dokan-form-group content-half-part samply-enable-area">
            <label for="samply_qty" class="form-label"><?php esc_html_e( 'Stock Quantity', 'samply' ); ?></label>
            <div class="dokan-input-group">
                <?php dokan_post_input_box( $post_id, 'samply_qty', array( 'class' => 'dokan-product-regular-price', 'placeholder' => __( '1', 'samply' ) ), 'number' ); ?>
            </div>
        </div>
     
        <div class="dokan-clearfix"></div>
    </div>
</div><!-- .product-sample-options -->