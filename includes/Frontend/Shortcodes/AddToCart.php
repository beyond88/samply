<?php

namespace Samply\Frontend\Shortcodes;

use Samply\Helper;

/**
* Shortcode for add to cart button 
* to order samply
*
* @since    1.0.0
* @param    none
* @return   object
*/
class AddToCart {

    /**
     * Private attributes
     * 
     * @var string
     */
    private $atts;

    /**
     * Initialize shortcode
     *
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    public function __construct() {
        add_shortcode( 'samply_add_to_cart_ajax', array( $this, 'samply_add_to_cart_ajax_shortcode' ) );
    }

    /**
     * Shortcode callback method
     *
     * @since   1.0.0
     * @access  public
     * @param   array
     * @return  string
     */
    public function samply_add_to_cart_ajax_shortcode( $atts ) {
        $this->atts = shortcode_atts( array(
            'product_id' => null,
        ), $atts );

        return $this->output();
    }

    /**
     * Render samply button
     *
     * @since    1.0.0
     * @access  public
     * @param    none
     * @return   string
     */
    public function output() {
        ob_start();

        if ( Helper::product_is_in_stock( $this->atts['product_id'] ) && Helper::check_is_in_cart( $this->atts['product_id'] ) ) {
            $setting = Helper::samply_settings();
            $button_label = isset( $setting['button_label'] ) ? sprintf(__( '%s', 'samply' ),$setting['button_label']) : __( 'Order a Sample', 'samply' );

            $sku = '';
            echo '<div style="margin-bottom:10px;">';
            echo '<a href="?add-to-cart='.$this->atts['product_id'].'" data-quantity="1" class="button product_type_simple samply_ajax_add_to_cart ajax_add_to_cart" data-product_id="'.$this->atts['product_id'].'" data-product_sku="'.$sku.'" rel="nofollow">'.$button_label.'</a>';
            echo '</div>';
        }
        ?>

        <script>
            jQuery(document).ready(function($) {
                $('#samply-add-to-cart-ajax-button').click(function(e) {
                    const $thisbutton = $(this);
                    e.preventDefault();

                    const product_id = $(this).data('product-id');

                    $.ajax({
                        url: wc_add_to_cart_params.wc_ajax_url.replace(
                            '%%endpoint%%',
                            'add_to_cart'
                        ),
                        type: 'POST',
                        data: {
                            product_id: product_id
                        },
                        beforeSend: function(response) {
                            $thisbutton.removeClass('added').addClass('loading');
                        },
                        complete: function(response) {
                            $thisbutton.addClass('added').removeClass('loading');
                        },
                        success: function(response) {
                            if (response.error & response.product_url) {
                                window.location = response.product_url;
                                return;
                            } else {
                                $(document.body).trigger('added_to_cart', [
                                    response.fragments,
                                    response.cart_hash
                                ]);

                                $('a[data-notification-link="cart-overview"]').click();
                            }
                        }
                    });
                });
            });
        </script>

        <?php
        return ob_get_clean();
    }
}
