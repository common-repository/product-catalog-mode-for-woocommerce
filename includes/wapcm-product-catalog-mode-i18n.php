<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wpartisan.net/
 * @since      1.0.0
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 * @author     wpArtisan
 */
class Wapcm_Product_Catalog_Mode_For_WooCommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function wapcm_load_plugin_textdomain() {

		load_plugin_textdomain(
			'product-catalog-mode-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
