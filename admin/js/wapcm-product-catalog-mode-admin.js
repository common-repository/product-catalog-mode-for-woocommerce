(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	$(function() {
		
		if ($('#wapcm_catalog_mode_settings-description').length > 0) {
			var ecm_for = $("#wapcm_enable_catelog_mode_for").val();
			//console.log(ecm_for);
			if ( ecm_for == 'hide-by-user-role' ) {
				$('.wc-settings-row-wapcm_sc').hide();
				$('.wc-settings-row-wapcm_sur').show();
			} else if ( ecm_for == 'hide-by-country' ) {
				$('.wc-settings-row-wapcm_sc').show();
				$('.wc-settings-row-wapcm_sur').hide();
			} else {
				$('.wc-settings-row-wapcm_sc').hide();
				$('.wc-settings-row-wapcm_sur').hide();
			}
			
			if ( ecm_for !== 'hide-only-for-visitor' ) {
				$('.wc-settings-row-wapcm_slrb').hide();
			}
			
		}
		
		$('select#wapcm_enable_catelog_mode_for').on('change', function() {

			if ( this.value == 'hide-by-user-role' ) {
				$('.wc-settings-row-wapcm_sc').hide();
				$('.wc-settings-row-wapcm_sur').show();
			} else if ( this.value == 'hide-by-country' ) {
				$('.wc-settings-row-wapcm_sc').show();
				$('.wc-settings-row-wapcm_sur').hide();
			} else {
				$('.wc-settings-row-wapcm_sc').hide();
				$('.wc-settings-row-wapcm_sur').hide();
			}
			
			if ( this.value == 'hide-only-for-visitor' ) {
				$('.wc-settings-row-wapcm_slrb').show();
			}else{
				$('.wc-settings-row-wapcm_slrb').hide();
			}
			
		});
		
		
		
	});

})( jQuery );
