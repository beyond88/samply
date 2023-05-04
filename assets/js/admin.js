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
			if (qVars.indexOf("samply") >= 0) {
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

		$(document).on('click', '#samply-manage-stock', function() {	
			if($(this).is(':checked')){
				$(".samply-enable-area").show();          
			} else {
				$(".samply-enable-area").hide();
			}
		});
		
		if( $('#samply-manage-stock').is(':checked') ) {
			$(".samply-enable-area").show();          
		} else {
			$(".samply-enable-area").hide();
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
