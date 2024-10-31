<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpartisan.net/
 * @since             1.0.0
 * @package           Wapcm_Product_Catalog_Mode_For_WooCommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Product Catalog Mode For WooCommerce
 * Description:       Product Catalog Mode For WooCommerce plugin can TURN INTO your online store as CATALOG ONLY MODE hiding by product price, Add to Cart button on a single click.
 * Version:           1.0.2
 * Author:            wpArtisan
 * Author URI:        https://wpartisan.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-catalog-mode-for-woocommerce
 * Domain Path:       /languages
 *
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
if ( function_exists( 'wapcm_fs' ) ) {
    wapcm_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'wapcm_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wapcm_fs() {
            global $wapcm_fs;
            if ( !isset( $wapcm_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/includes/freemius/start.php';
                $wapcm_fs = fs_dynamic_init( array(
                    'id'             => '16251',
                    'slug'           => 'product-catalog-mode-for-woocommerce',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_81579b72cd00823d00325cb032c69',
                    'is_premium'     => false,
                    'premium_suffix' => 'Premium',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                        'slug'           => 'wc-settings',
                        'override_exact' => true,
                        'first-path'     => 'admin.php?page=wc-settings&tab=woo-product-catalog-mode-settings',
                        'support'        => false,
                        'parent'         => array(
                            'slug' => 'woocommerce',
                        ),
                    ),
                    'is_live'        => true,
                ) );
            }
            return $wapcm_fs;
        }

        // Init Freemius.
        wapcm_fs();
        // Signal that SDK was initiated.
        do_action( 'wapcm_fs_loaded' );
        function wapcm_fs_settings_url() {
            return admin_url( 'admin.php?page=wc-settings&tab=woo-product-catalog-mode-settings' );
        }

        wapcm_fs()->add_filter( 'connect_url', 'wapcm_fs_settings_url' );
        wapcm_fs()->add_filter( 'after_skip_url', 'wapcm_fs_settings_url' );
        wapcm_fs()->add_filter( 'after_connect_url', 'wapcm_fs_settings_url' );
        wapcm_fs()->add_filter( 'after_pending_connect_url', 'wapcm_fs_settings_url' );
    }
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'WAPCM_VERSION', '1.0.2' );
    if ( !function_exists( 'wapcm_product_catalog_mode_admin_notice' ) ) {
        /**
         *  Show an admin notice if WooCommerce is not activated
         *
         */
        function wapcm_product_catalog_mode_admin_notice() {
            ?>
			<div class="error">
				<p><?php 
            esc_html_e( 'Product Catalog Mode For WooCommerce Plugin is enabled but not effective. In order to work it requires WooCommerce.', 'product-catalog-mode-for-woocommerce' );
            ?></p>
			</div>
			<?php 
        }

    }
    add_action( 'plugins_loaded', 'wapcm_product_catalog_mode_install', 12 );
    /**
     * Add plugin page settings link.
     * @since    1.0.0
     */
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wapcm_add_plugin_page_settings_link' );
    function wapcm_add_plugin_page_settings_link(  $links  ) {
        $links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=woo-product-catalog-mode-settings' ) . '">' . esc_html__( 'Settings', 'product-catalog-mode-for-woocommerce' ) . '</a>';
        if ( wapcm_fs()->is_not_paying() ) {
            $links[] = '<a class="wapcm-plugins-gopro" href="' . wapcm_fs()->get_upgrade_url() . '">' . esc_html__( 'Go Pro', 'product-catalog-mode-for-woocommerce' ) . '</a>';
        }
        return $links;
    }

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/wapcm-product-catalog-mode-activator.php
     */
    function wapcm_activate_product_catalog_mode() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/wapcm-product-catalog-mode-activator.php';
        Wapcm_Product_Catalog_Mode_For_WooCommerce_Activator::wapcm_activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/wapcm-product-catalog-mode-deactivator.php
     */
    function wapcm_deactivate_product_catalog_mode() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/wapcm-product-catalog-mode-deactivator.php';
        Wapcm_Product_Catalog_Mode_For_WooCommerce_Deactivator::wapcm_deactivate();
    }

    register_activation_hook( __FILE__, 'wapcm_activate_product_catalog_mode' );
    register_deactivation_hook( __FILE__, 'wapcm_deactivate_product_catalog_mode' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/wapcm-product-catalog-mode.php';
    /**
     * Add admin notice.
     * @since    1.0.0
     */
    add_action( 'admin_notices', 'wapcm_admin_notice' );
    function wapcm_admin_notice() {
        global $current_user;
        if ( isset( $_SERVER['HTTPS'] ) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $current_url = '';
        if ( !empty( $_SERVER['HTTP_HOST'] ) && !empty( $_SERVER['REQUEST_URI'] ) ) {
            $host = sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
            $request_uri = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
            $current_url = $protocol . $host . $request_uri;
        }
        $parse_url = wp_parse_url( $current_url );
        if ( isset( $parse_url['query'] ) && !empty( $parse_url['query'] ) ) {
            $current_url = $current_url . '&wapcm_igne_noti=1';
        } else {
            $current_url = $current_url . '?wapcm_igne_noti=1';
        }
        $user_id = $current_user->ID;
        if ( !get_user_meta( $user_id, 'wapcm_igne_noti' ) ) {
            if ( wapcm_fs()->is_not_paying() ) {
                echo '<div class="updated"><p>';
                echo '<h3>' . esc_html__( 'Awesome Premium Features in Product Catalog Mode For WooCommerce Plugin', 'product-catalog-mode-for-woocommerce' ) . '</h3>';
                echo '<ul>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Enable catalog mode based on user roles', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Enable catalog mode based on countries', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Inquiry form to collect customer inquiries for each product', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Disable catalog mode for categories', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Disable catalog mode for Individual products', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Disable inquiry form for individual products', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Disable the global custom message and add a custom message for individual products', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Redirect products to third-party or affiliate sites, by assigning a custom URL for products', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '<li><span class="dashicons dashicons-yes"></span> ' . esc_html__( 'Priority email support', 'product-catalog-mode-for-woocommerce' ) . '</li>';
                echo '</ul>';
                echo '<a href="' . esc_url( wapcm_fs()->get_upgrade_url() ) . '" class="upgradebtn">' . esc_html__( 'Upgrade Now!', 'product-catalog-mode-for-woocommerce' ) . '</a>&nbsp;&nbsp;';
                echo '<a href="' . esc_url( $current_url ) . '" class="hidebtn">' . esc_html__( 'Hide this notice', 'product-catalog-mode-for-woocommerce' ) . '</a>';
                echo "</p></div>";
            }
        }
    }

    /**
     * Ignore admin notice.
     * @since    1.0.0
     */
    add_action( 'admin_init', 'wapcm_ignore_notice' );
    function wapcm_ignore_notice() {
        if ( isset( $_GET['wapcm_igne_noti'] ) && 1 == $_GET['wapcm_igne_noti'] ) {
            global $current_user;
            $user_id = $current_user->ID;
            add_user_meta(
                $user_id,
                'wapcm_igne_noti',
                'true',
                true
            );
        }
    }

    wapcm_fs()->add_action( 'after_uninstall', 'wapcm_fs_uninstall_cleanup' );
    function wapcm_fs_uninstall_cleanup() {
        $options = array(
            'wapcm_enable_catalog_mode',
            'wapcm_enable_catelog_mode_for',
            'wapcm_show_login_reg_button',
            'wapcm_hide_product_price',
            'wapcm_message_enable',
            'wapcm_global_message',
            'wapcm_message_option_shows_on'
        );
        foreach ( $options as $option_name ) {
            delete_option( $option_name );
        }
    }

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function wapcm_run_product_catalog_mode() {
        $plugin = new Wapcm_Product_Catalog_Mode_For_WooCommerce();
        $plugin->wapcm_run();
    }

    function wapcm_product_catalog_mode_install() {
        if ( !function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'wapcm_product_catalog_mode_admin_notice' );
        } else {
            wapcm_run_product_catalog_mode();
        }
    }

}