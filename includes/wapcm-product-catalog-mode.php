<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpartisan.net/
 * @since      1.0.0
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/includes
 * @author     wpArtisan
 */
class Wapcm_Product_Catalog_Mode_For_WooCommerce {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'WAPCM_VERSION' ) ) {
            $this->version = WAPCM_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'product-catalog-mode-for-woocommerce';
        $this->wapcm_load_dependencies();
        $this->wapcm_set_locale();
        $this->wapcm_define_admin_hooks();
        $this->wapcm_define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader. Orchestrates the hooks of the plugin.
     * - Wapcm_Product_Catalog_Mode_For_WooCommerce_i18n. Defines internationalization functionality.
     * - Wapcm_Product_Catalog_Mode_For_WooCommerce_Admin. Defines all hooks for the admin area.
     * - Wapcm_Product_Catalog_Mode_For_WooCommerce_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wapcm_load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wapcm-product-catalog-mode-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wapcm-product-catalog-mode-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wapcm-product-catalog-mode-admin.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/wapcm-product-catalog-mode-public.php';
        $this->loader = new Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wapcm_Product_Catalog_Mode_For_WooCommerce_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wapcm_set_locale() {
        $plugin_i18n = new Wapcm_Product_Catalog_Mode_For_WooCommerce_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'wapcm_load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wapcm_define_admin_hooks() {
        $plugin_admin = new Wapcm_Product_Catalog_Mode_For_WooCommerce_Admin($this->wapcm_get_plugin_name(), $this->wapcm_get_version());
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wapcm_enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'wapcm_enqueue_scripts' );
        $this->loader->add_action( 'woocommerce_admin_field_multicheckbox', $plugin_admin, 'wapcm_output_multicheckbox_fields' );
        $this->loader->add_filter(
            'woocommerce_admin_settings_sanitize_option_wapcm_message_option_shows_on',
            $plugin_admin,
            'wapcm_sanitize_multicheckbox_option',
            10,
            3
        );
        //plugin settions options
        $this->loader->add_action(
            'woocommerce_settings_tabs_array',
            $plugin_admin,
            'wapcm_add_settings_tab',
            50
        );
        $this->loader->add_action( 'woocommerce_settings_tabs_woo-product-catalog-mode-settings', $plugin_admin, 'wapcm_settings_tab' );
        $this->loader->add_action(
            'woocommerce_update_options_woo-product-catalog-mode-settings',
            $plugin_admin,
            'wapcm_update_settings',
            10,
            2
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function wapcm_define_public_hooks() {
        $plugin_public = new Wapcm_Product_Catalog_Mode_For_WooCommerce_Public($this->wapcm_get_plugin_name(), $this->wapcm_get_version());
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wapcm_enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'wapcm_enqueue_scripts' );
        // hide product price
        $this->loader->add_filter(
            'woocommerce_get_price_html',
            $plugin_public,
            'wapcm_hide_price_for_product',
            10,
            2
        );
        //remove add to cart button
        $this->loader->add_filter(
            'woocommerce_loop_add_to_cart_link',
            $plugin_public,
            'wapcm_woocommerce_loop_add_to_cart_link',
            10,
            3
        );
        $this->loader->add_action(
            'woocommerce_simple_add_to_cart',
            $plugin_public,
            'wapcm_remove_add_to_cart_from_single_product',
            10
        );
        $this->loader->add_action(
            'woocommerce_variable_add_to_cart',
            $plugin_public,
            'wapcm_remove_add_to_cart_from_single_product',
            10
        );
        $this->loader->add_action(
            'woocommerce_grouped_add_to_cart',
            $plugin_public,
            'wapcm_remove_add_to_cart_from_single_product',
            10
        );
        $this->loader->add_action(
            'woocommerce_external_add_to_cart',
            $plugin_public,
            'wapcm_remove_add_to_cart_from_single_product',
            10
        );
        $this->loader->add_filter(
            'woocommerce_blocks_product_grid_item_html',
            $plugin_public,
            'wapcm_blocks_product_grid_item_html',
            10,
            3
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function wapcm_run() {
        $this->loader->wapcm_run_loader();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function wapcm_get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Wapcm_Product_Catalog_Mode_For_WooCommerce_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function wapcm_get_version() {
        return $this->version;
    }

}
