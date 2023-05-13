<?php
 
    $samply_manage_stock    = get_post_meta( $post->ID, 'samply_manage_stock', true );  
    $samply_qty = get_post_meta( $post->ID, 'samply_qty', true );
    if( empty( $samply_qty ) ) {
        $samply_qty = 0;
    }

    $samply_price   = ! empty( get_post_meta( $post->ID, 'samply_price', true ) ) ? get_post_meta( $post->ID, 'samply_price', true ):0; 
    $_product   = wc_get_product( $post->ID );


?>
<div id="samply-tab" class="panel wc-metaboxes-wrapper woocommerce_options_panel">

    <div class="options_group">
        <p class="form-field comment_status_field">
            <label for="manage_stock"><?php esc_html_e( 'Manage stock?', 'samply' ); ?></label>
            <input type="checkbox" class="checkbox manage_stock" name="samply_manage_stock" id="samply-manage-stock" value="<?php echo esc_attr( $samply_manage_stock ); ?>" <?php checked( 1, $samply_manage_stock, true ); ?>> 
        </p>

        <p class="form-field menu_order_field samply-enable-area">
            <label for="samply_qty"><?php esc_html_e( 'Stock quantity', 'samply' ); ?></label>
            <input type="number" class="short" name="samply_qty" id="samply_qty" value="<?php echo esc_attr( $samply_qty );  ?>" step="1"> 
        </p>
    </div>
    
    <?php if( $_product->is_type( 'simple' ) ) { ?>
    <div class="options_group">
        <p class="form-field">
            <label for="samply_price">
                <?php esc_html_e( 'Sample Price', 'samply' ); ?>
                <?php echo ' (' . get_woocommerce_currency_symbol() . ')'; ?>
            </label>
            <input type="text" class="short wc_input_price" name="samply_price" id="samply_price" value="<?php echo esc_attr( $samply_price );  ?>"> 
        </p>
    </div>
    <?php } ?>  
    
</div>