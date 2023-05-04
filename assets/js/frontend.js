/* global wc_add_to_cart_params */
jQuery( function( $ ) {

    if ( typeof wc_add_to_cart_params === 'undefined' ) {
        return false;
    }

    /**
     * AddToCartHandler class.
     */
    var SamplyAddToCartHandler = function() {
        this.requests   = [];
        this.addRequest = this.addRequest.bind( this );
        this.run        = this.run.bind( this );

        $( document.body )
            .on( 'click', '.samply_ajax_add_to_cart', { addToCartHandler: this }, this.onAddToCart )
    };

    /**
     * Add add to cart event.
     */
    SamplyAddToCartHandler.prototype.addRequest = function( request ) {
        this.requests.push( request );

        if ( 1 === this.requests.length ) {
            this.run();
        }
    };

    /**
     * Run add to cart events.
     */
    SamplyAddToCartHandler.prototype.run = function() {
        var requestManager = this,
            originalCallback = requestManager.requests[0].complete;

        requestManager.requests[0].complete = function() {
            if ( typeof originalCallback === 'function' ) {
                originalCallback();
            }

            requestManager.requests.shift();

            if ( requestManager.requests.length > 0 ) {
                requestManager.run();
            }
        };

        $.ajax( this.requests[0] );
    };

    /**
     * Handle the add to cart event.
     */
    SamplyAddToCartHandler.prototype.onAddToCart = function( e ) {
        var $thisbutton = $( this );

        if ( $thisbutton.is( '.ajax_add_to_cart' ) ) {
            if ( ! $thisbutton.attr( 'data-product_id' ) ) {
                return true;
            }

            e.preventDefault();

            $thisbutton.removeClass( 'added' );
            $thisbutton.addClass( 'loading' );

            var data = {};

            // Fetch changes that are directly added by calling $thisbutton.data( key, value )
            $.each( $thisbutton.data(), function( key, value ) {
                data[ key ] = value;
            });

            // Fetch data attributes in $thisbutton. Give preference to data-attributes because they can be directly modified by javascript
            // while `.data` are jquery specific memory stores.
            $.each( $thisbutton[0].dataset, function( key, value ) {
                data[ key ] = value;
            });

            // Trigger event.
            $( document.body ).trigger( 'adding_to_cart', [ $thisbutton, data ] );

            e.data.addToCartHandler.addRequest({
                type: 'POST',
                // url: wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' ),
				url:ajax.ajax_url,
				data: {
					action: 'add_to_cart',
					data:data
				},
                success: function( response ) {

                    if ( ! response ) {
                        return;
                    }

                    if ( response.error && response.product_url ) {
                        window.location = response.product_url;
                        return;
                    }

                    // Redirect to cart option
                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    }

                    // Trigger event so themes can refresh other areas.
                    $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                dataType: 'json'
            });
        }
    };

    /**
     * Init AddToCartHandler.
     */
    new SamplyAddToCartHandler();

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    $(document).on('click', '.mini_cart_item a.remove', function (e){
        e.preventDefault();

        var product_id = $(this).attr("data-product_id"),
            cart_item_key = $(this).attr("data-cart_item_key"),
            product_container = $(this).parents('.mini_cart_item');
        product_href = $(this).attr('href');
        let _wpnonce = getParameterByName('_wpnonce', product_href);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: "product_remove",
                product_id: product_id,
                cart_item_key: cart_item_key,
                _wpnonce: _wpnonce
            },
            success: function(response) {},
            error: function(response) {}
        });
    });

});


