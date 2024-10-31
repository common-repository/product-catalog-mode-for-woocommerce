<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpartisan.net/
 * @since      1.0.0
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/admin
 * @author     wpArtisan
 */
class Wapcm_Product_Catalog_Mode_For_WooCommerce_Admin {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function wapcm_enqueue_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/wapcm-product-catalog-mode-admin.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function wapcm_enqueue_scripts() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/wapcm-product-catalog-mode-admin.js',
            array('jquery'),
            $this->version,
            false
        );
    }

    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     * @since    1.0.0
     */
    public function wapcm_add_settings_tab( $settings_tabs ) {
        $settings_tabs['woo-product-catalog-mode-settings'] = esc_html__( 'Product Catalog Settings', 'product-catalog-mode-for-woocommerce' );
        return $settings_tabs;
    }

    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses $this->wcuo_settings_tab()
     * @since    1.0.0
     */
    public function wapcm_settings_tab() {
        woocommerce_admin_fields( $this->wapcm_get_settings() );
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     * @since    1.0.0
     */
    public function wapcm_get_settings() {
        // Common section
        $settings = array(
            'section_woo_catalog_mode'      => array(
                'name' => esc_html__( 'WooCommerce Catalog Mode', 'product-catalog-mode-for-woocommerce' ),
                'type' => 'title',
                'desc' => esc_html__( 'WooCommerce Catalog Mode allows you to turn your Shop into a Catalog Mode, by hiding product prices or Add to Cart Button on product pages.', 'product-catalog-mode-for-woocommerce' ),
                'id'   => 'wapcm_catalog_mode_settings',
            ),
            'enable_catelog_mode'           => array(
                'name'     => esc_html__( 'Enable Catalog Mode', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'checkbox',
                'desc'     => esc_html__( 'Enable Catalog Mode for your Online Store.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_enable_catalog_mode',
                'default'  => 'no',
            ),
            'enable_catelog_mode_for'       => array(
                'name'     => esc_html__( 'Enable catalog mode for', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'select',
                'options'  => ( wapcm_fs()->is_not_paying() ? array(
                    'for-all'               => esc_html__( 'All', 'product-catalog-mode-for-woocommerce' ),
                    'hide-only-for-visitor' => esc_html__( 'Visitors', 'product-catalog-mode-for-woocommerce' ),
                ) : array(
                    'for-all'               => esc_html__( 'All', 'product-catalog-mode-for-woocommerce' ),
                    'hide-only-for-visitor' => esc_html__( 'Visitors', 'product-catalog-mode-for-woocommerce' ),
                    'hide-by-user-role'     => esc_html__( 'Specific User Roles', 'product-catalog-mode-for-woocommerce' ),
                    'hide-by-country'       => esc_html__( 'Specific Countries', 'product-catalog-mode-for-woocommerce' ),
                ) ),
                'desc'     => esc_html__( 'Enable catalog mode for all users or visitors only or specific user roles or specific countries', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_enable_catelog_mode_for',
            ),
            'show_login_reg_button'         => array(
                'name'      => esc_html__( 'Show Login/Register Button', 'product-catalog-mode-for-woocommerce' ),
                'type'      => 'checkbox',
                'desc'      => esc_html__( 'Show the Login/Register button on the product details page when the catalog mode is enabled only for visitors.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip'  => true,
                'id'        => 'wapcm_show_login_reg_button',
                'default'   => 'no',
                'row_class' => 'wapcm_slrb',
            ),
            'wapcm_hide_product_price'      => array(
                'name'     => esc_html__( 'Hide product price', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'checkbox',
                'desc'     => esc_html__( 'Hide product price for your Online Store.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_hide_product_price',
                'default'  => 'no',
            ),
            'wapcm_message_enable'          => array(
                'name'     => esc_html__( 'Show custom message', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'checkbox',
                'desc'     => esc_html__( 'Show a custom message when enable catalog mode for your Online Store. The message will be shown on the product details page.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_message_enable',
                'default'  => 'no',
            ),
            'wapcm_global_message'          => array(
                'name'     => esc_html__( 'Message', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'textarea',
                'desc'     => esc_html__( 'This message will be shown on the product details page for each product.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_global_message',
            ),
            'wapcm_message_option_shows_on' => array(
                'name'     => esc_html__( 'Show Message on', 'product-catalog-mode-for-woocommerce' ),
                'type'     => 'multicheckbox',
                'desc'     => esc_html__( 'The above message will be shown on the product archive pages and product details page based on your selection.', 'product-catalog-mode-for-woocommerce' ),
                'desc_tip' => true,
                'id'       => 'wapcm_message_option_shows_on',
            ),
            'section_woo_catalog_mode_end'  => array(
                'type' => 'sectionend',
                'id'   => 'wapcm_woo_catalog_mode_section_end',
            ),
        );
        return apply_filters( 'wapcm_product_catalog_mode_settings', $settings );
    }

    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses $this->get_settings()
     * @since    1.0.0
     */
    public function wapcm_update_settings() {
        woocommerce_update_options( $this->wapcm_get_settings() );
    }

    public function wapcm_output_multicheckbox_fields( $value ) {
        $option_value = (array) WC_Admin_Settings::get_option( $value['id'] );
        ?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php 
        echo esc_attr( $value['id'] );
        ?>"><?php 
        echo esc_html( $value['title'] );
        ?></label>
				<?php 
        echo wp_kses_post( wc_help_tip( $value['desc'] ) );
        ?>
			</th>
			<td class="forminp forminp-<?php 
        echo esc_attr( sanitize_title( $value['type'] ) );
        ?>">
				<fieldset>

					<ul class="" style="margin:0; padding:0;">
					<?php 
        $message_option_shows_on = array(
            'shop-and-archive-pages' => esc_html__( 'Shop and archive pages', 'product-catalog-mode-for-woocommerce' ),
            'product-details-page'   => esc_html__( 'Product details page', 'product-catalog-mode-for-woocommerce' ),
        );
        $index = 0;
        $count = count( $message_option_shows_on );
        $numItemsPerRow = ceil( $count / 2 );
        $numItemsOffsetFix = $count % 2 == 1;
        echo '<div class="columns" style="width:auto; display:inline-block; height:auto; float:left; padding:0; margin:0 25px 0 0;">';
        foreach ( $message_option_shows_on as $key => $val ) {
            if ( $index > 0 and $index % $numItemsPerRow == 0 ) {
                echo '</div><div class="columns">';
                if ( $numItemsOffsetFix ) {
                    $numItemsPerRow--;
                    $numItemsOffsetFix = false;
                }
            }
            ?>
							<li style="">
								<label><input type="checkbox" 
									name="<?php 
            echo esc_attr( $value['id'] );
            ?>[]"
									id="<?php 
            echo esc_attr( $val );
            ?>"
									value="<?php 
            echo esc_attr( $key );
            ?>" 
									<?php 
            if ( in_array( $key, $option_value ) ) {
                echo ' checked="checked"';
            }
            ?>/><?php 
            echo esc_html( $val );
            ?>
								</label>
							</li>
							<?php 
            $index++;
        }
        ?>
					</ul>
				</fieldset>
			</td>
		</tr><?php 
    }

    public function wapcm_sanitize_multicheckbox_option( $value, $option, $raw_value ) {
        $value = array_filter( array_map( 'wc_clean', (array) $raw_value ) );
        return $value;
    }

}
