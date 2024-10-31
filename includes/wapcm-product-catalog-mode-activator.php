<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpartisan.net/
 * @since      1.0.0
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 * @author     wpArtisan
 */
class Wapcm_Product_Catalog_Mode_For_WooCommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function wapcm_activate() {
		if ( ! get_option( 'wapcm_enable_catalog_mode' ) ) {
			update_option( 'wapcm_enable_catalog_mode', 'yes' );
		}
		if ( ! get_option( 'wapcm_enable_catelog_mode_for' ) ) {
			update_option( 'wapcm_enable_catelog_mode_for', 'for-all' );
		}
	}

}
