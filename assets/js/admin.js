// ;(function($) {

//     $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
//         e.preventDefault();

//         if (!confirm(samply.confirm)) {
//             return;
//         }

//         var self = $(this),
//             id = self.data('id');

//         wp.ajax.post('samply-delete-contact', {
//             id: id,
//             _wpnonce: samply.nonce
//         })
//         .done(function(response) {

//             self.closest('tr')
//                 .css('background-color', 'red')
//                 .hide(400, function() {
//                     $(this).remove();
//                 });

//         })
//         .fail(function() {
//             alert(samply.error);
//         });
//     });

// })(jQuery);

// jQuery(function ($) {

//     let enable_type = $("#enable_type").val();
//     if( enable_type == 'product' ) {
//         $('.wfps-enable-product-area').show();
//         $('.wfps-enable-category-area').hide();
//     } else {
//         $('.wfps-enable-product-area').hide();
//         $('.wfps-enable-category-area').show();
//     }

//     let exclude_type = $("#exclude_type").val();
//     if( exclude_type == 'product' ) {
//         $('.exclude_product_area').show();
//         $('.exclude_category_area').hide();
//     } else {
//         $('.exclude_product_area').hide();
//         $('.exclude_category_area').show();
//     }

// 	let manage_stock = $("#wfps-manage-stock").val();
//     if( manage_stock == 1 ) {
//         $(".wfps-enable-area").show();
//     }   
        
//     if( $('#disable_limit_per_order').is( ':checked' ) ) {
//         $('.limit_per_order_area').hide();
//         $('.max_qty_per_order_area').hide();
//     }

//     $(document).on( 'click', '#disable_limit_per_order', function(){
//         if( $('#disable_limit_per_order').is( ':checked' ) ) {
//             $('.limit_per_order_area').hide();
//             $('.max_qty_per_order_area').hide();
//         } else {
//             $('.limit_per_order_area').show();
//             $('.max_qty_per_order_area').show();
//         }   
//     });

//     $(document).ready(function(){
//         $('.wfps_tab').click(function(){
//             $(".wfps_builder_tab").removeClass('wfps-tab-active');
//             $(".wfps_builder_tab[data-id='"+$(this).attr('data-id')+"']").addClass("wfps-tab-active");
//             $("#wfps_builder_id").val($(this).attr('data-id'));            
//             $(".wfps_tab").removeClass('wfps_tab_active');
//             $(this).parent().find(".wfps_tab").addClass('wfps_tab_active');
//         });
//     });    
    
// });

(function ($) {
	"use strict";

	/**
	 * Samply Admin JS
	 */
	$.samplyAdmin = $.samplyAdmin || {};

    $(document).ready(function () {
		$.samplyAdmin.init();

        var qVars = $.samplyAdmin.get_query_vars("page");
		if (qVars != undefined) {
			if (qVars.indexOf("samply-settings") >= 0) {
				var cSettingsTab = qVars.split("#");
				$(
					'.samply-settings-menu li[data-tab="' +
						cSettingsTab[1] +
						'"]'
				).trigger("click");
			}
		}

		if( $('#disable_limit_per_order').is( ':checked' ) ) {
			$('.limit_per_order_area').hide();
			$('.max_qty_per_order_area').hide();
    	}

	});

    $.samplyAdmin.init = function () {
		// $.samplyAdmin.toggleFields();
		$.samplyAdmin.bindEvents();
		// $.samplyAdmin.initializeFields();
	};

    $.samplyAdmin.bindEvents = function () {
		$(".samply-settings-menu li").on("click", function (e) {
			$.samplyAdmin.settingsTab(this);
		});

        $('.samply-settings-button').removeClass('button');

		$(document).on( 'click', '#disable_limit_per_order', function(){
			if( $('#disable_limit_per_order').is( ':checked' ) ) {
				$('.limit_per_order_area').hide();
				$('.max_qty_per_order_area').hide();
			} else {
				$('.limit_per_order_area').show();
				$('.max_qty_per_order_area').show();
			}   
    	});		
    };

    $.samplyAdmin.settingsTab = function (button) {
		var button = $(button),
			tabToGo = button.data("tab");

		button.addClass("active").siblings().removeClass("active");
		$("#samply-" + tabToGo)
			.addClass("active")
			.siblings()
			.removeClass("active");

		$('#samply_builder_id').val(tabToGo);	
	};

    $.samplyAdmin.get_query_vars = function (name) {
		var vars = {};
		window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (
			m,
			key,
			value
		) {
			vars[key] = value;
		});
		if (name != "") {
			return vars[name];
		}
		return vars;
	};

})(jQuery);
