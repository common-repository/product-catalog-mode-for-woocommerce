<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpartisan.net/
 * @since      1.0.0
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wapcm_Product_Catalog_Mode_For_WooCommerce
 * @subpackage Wapcm_Product_Catalog_Mode_For_WooCommerce/public
 * @author     wpArtisan
 */
class Wapcm_Product_Catalog_Mode_For_WooCommerce_Public {
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
            plugin_dir_url( __FILE__ ) . 'css/wapcm-product-catalog-mode-public.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
            plugin_dir_url( __FILE__ ) . 'js/wapcm-product-catalog-mode-public.js',
            array('jquery'),
            $this->version,
            false
        );
        wp_localize_script( $this->plugin_name, 'js_vars', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ) );
    }

    /**
     * Hide product price based on settings.
     *
     * @since    1.0.0
     */
    public function wapcm_hide_price_for_product( $price, $product ) {
        if ( !is_admin() ) {
            $product_id = $product->get_id();
            $wapcm_enable_catalog_mode = get_option( 'wapcm_enable_catalog_mode' );
            $wapcm_hide_product_price = get_option( 'wapcm_hide_product_price' );
            $wapcm_enable_catelog_mode_for = get_option( 'wapcm_enable_catelog_mode_for' );
            if ( isset( $wapcm_enable_catalog_mode ) && $wapcm_enable_catalog_mode == 'yes' ) {
                if ( isset( $wapcm_hide_product_price ) && $wapcm_hide_product_price == 'yes' ) {
                    if ( $wapcm_enable_catelog_mode_for == 'for-all' ) {
                        $hide = true;
                        if ( $hide ) {
                            return '';
                        }
                    }
                    if ( $wapcm_enable_catelog_mode_for == 'hide-only-for-visitor' ) {
                        if ( !is_user_logged_in() ) {
                            $hide = true;
                            if ( $hide ) {
                                return '';
                            }
                        }
                    }
                }
            }
        }
        return $price;
    }

    /**
     * To hide add to cart button from shop archive page.
     *
     * @since    1.0.0
     */
    public function wapcm_woocommerce_loop_add_to_cart_link( $output, $product, $args ) {
        $product_id = $product->get_id();
        $wapcm_enable_catalog_mode = get_option( 'wapcm_enable_catalog_mode' );
        $wapcm_enable_catelog_mode_for = get_option( 'wapcm_enable_catelog_mode_for' );
        if ( isset( $wapcm_enable_catalog_mode ) && $wapcm_enable_catalog_mode == 'yes' ) {
            if ( $wapcm_enable_catelog_mode_for == 'for-all' ) {
                $hide = true;
                if ( $hide ) {
                    $output = '';
                    $output .= $this->wapcm_woocommerce_template_loop_custom_message( $product );
                    $wapcm_change_product_url = get_post_meta( $product_id, 'wapcm_change_product_url', true );
                    $wapcm_changed_product_url = trim( get_post_meta( $product_id, 'wapcm_changed_product_url', true ) );
                    if ( isset( $wapcm_change_product_url ) && $wapcm_change_product_url == 'yes' && !empty( $wapcm_changed_product_url ) ) {
                        $output .= $this->wapcm_add_external_url_button__premium_only();
                    }
                }
            }
            if ( $wapcm_enable_catelog_mode_for == 'hide-only-for-visitor' ) {
                if ( !is_user_logged_in() ) {
                    $hide = true;
                    if ( $hide ) {
                        $output = '';
                        $output .= $this->wapcm_woocommerce_template_loop_custom_message( $product );
                        $wapcm_change_product_url = get_post_meta( $product_id, 'wapcm_change_product_url', true );
                        $wapcm_changed_product_url = trim( get_post_meta( $product_id, 'wapcm_changed_product_url', true ) );
                        if ( isset( $wapcm_change_product_url ) && $wapcm_change_product_url == 'yes' && !empty( $wapcm_changed_product_url ) ) {
                            $output .= $this->wapcm_add_external_url_button__premium_only();
                        }
                    }
                }
            }
        }
        return $output;
    }

    /**
     * To hide add to cart button from woocommerce blocks product grid item html.
     *
     * @since    1.0.2
     */
    public function wapcm_blocks_product_grid_item_html( $output, $data, $product ) {
        $product_id = $product->get_id();
        $wapcm_enable_catalog_mode = get_option( 'wapcm_enable_catalog_mode' );
        $wapcm_enable_catelog_mode_for = get_option( 'wapcm_enable_catelog_mode_for' );
        if ( isset( $wapcm_enable_catalog_mode ) && $wapcm_enable_catalog_mode == 'yes' ) {
            if ( $wapcm_enable_catelog_mode_for == 'for-all' ) {
                $hide = true;
                if ( $hide ) {
                    $data->button = $this->wapcm_woocommerce_template_loop_custom_message( $product );
                    $output = "<li class=\"wc-block-grid__product\">\n\t\t\t\t\t\t<a href=\"{$data->permalink}\" class=\"wc-block-grid__product-link\">\n\t\t\t\t\t\t\t{$data->badge}\n\t\t\t\t\t\t\t{$data->image}\n\t\t\t\t\t\t\t{$data->title}\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t{$data->price}\n\t\t\t\t\t\t{$data->rating}\n\t\t\t\t\t\t{$data->button}\n\t\t\t\t\t</li>";
                }
            }
            if ( $wapcm_enable_catelog_mode_for == 'hide-only-for-visitor' ) {
                if ( !is_user_logged_in() ) {
                    $hide = true;
                    if ( $hide ) {
                        $data->button = $this->wapcm_woocommerce_template_loop_custom_message( $product );
                        $output = "<li class=\"wc-block-grid__product\">\n\t\t\t\t\t\t\t<a href=\"{$data->permalink}\" class=\"wc-block-grid__product-link\">\n\t\t\t\t\t\t\t\t{$data->badge}\n\t\t\t\t\t\t\t\t{$data->image}\n\t\t\t\t\t\t\t\t{$data->title}\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t{$data->price}\n\t\t\t\t\t\t\t{$data->rating}\n\t\t\t\t\t\t\t{$data->button}\n\t\t\t\t\t\t</li>";
                    }
                }
            }
        }
        return $output;
    }

    /**
     * To hide add to cart button from shop single page.
     *
     * @since    1.0.0
     */
    public function wapcm_remove_add_to_cart_from_single_product() {
        global $product;
        $product_id = $product->get_id();
        $product_get_type = $product->get_type();
        if ( $product_id ) {
            $wapcm_enable_catalog_mode = get_option( 'wapcm_enable_catalog_mode' );
            $wapcm_enable_catelog_mode_for = get_option( 'wapcm_enable_catelog_mode_for' );
            if ( isset( $wapcm_enable_catalog_mode ) && $wapcm_enable_catalog_mode == 'yes' ) {
                if ( isset( $wapcm_enable_catelog_mode_for ) && !empty( $wapcm_enable_catelog_mode_for ) && $wapcm_enable_catelog_mode_for === 'for-all' ) {
                    $hide = true;
                    if ( $hide ) {
                        remove_action( 'woocommerce_' . $product_get_type . '_add_to_cart', 'woocommerce_' . $product_get_type . '_add_to_cart', 30 );
                        add_action( 'woocommerce_' . $product_get_type . '_add_to_cart', array($this, 'wapcm_woocommerce_template_single_custom_message'), 30 );
                        $wapcm_change_product_url = get_post_meta( $product_id, 'wapcm_change_product_url', true );
                        $wapcm_changed_product_url = trim( get_post_meta( $product_id, 'wapcm_changed_product_url', true ) );
                        if ( isset( $wapcm_change_product_url ) && $wapcm_change_product_url == 'yes' && !empty( $wapcm_changed_product_url ) ) {
                            add_action( 'woocommerce_' . $product_get_type . '_add_to_cart', array($this, 'wapcm_add_external_url_button__premium_only'), 30 );
                        }
                    }
                }
                if ( isset( $wapcm_enable_catelog_mode_for ) && !empty( $wapcm_enable_catelog_mode_for ) && $wapcm_enable_catelog_mode_for === 'hide-only-for-visitor' ) {
                    if ( !is_user_logged_in() ) {
                        $hide = true;
                        if ( $hide ) {
                            remove_action( 'woocommerce_' . $product_get_type . '_add_to_cart', 'woocommerce_' . $product_get_type . '_add_to_cart', 30 );
                            add_action( 'woocommerce_' . $product_get_type . '_add_to_cart', array($this, 'wapcm_woocommerce_template_single_custom_message'), 30 );
                            $wapcm_change_product_url = get_post_meta( $product_id, 'wapcm_change_product_url', true );
                            $wapcm_changed_product_url = trim( get_post_meta( $product_id, 'wapcm_changed_product_url', true ) );
                            if ( isset( $wapcm_change_product_url ) && $wapcm_change_product_url == 'yes' && !empty( $wapcm_changed_product_url ) ) {
                                add_action( 'woocommerce_' . $product_get_type . '_add_to_cart', array($this, 'wapcm_add_external_url_button__premium_only'), 30 );
                            }
                            add_action( 'woocommerce_' . $product_get_type . '_add_to_cart', array($this, 'wapcm_woocommerce_template_single_login_register_button'), 30 );
                        }
                    }
                }
            }
        }
    }

    /**
     * Show custom message.
     *
     * @since    1.0.0
     */
    public function wapcm_woocommerce_template_single_custom_message() {
        global $product;
        $product_id = $product->get_id();
        if ( $product_id ) {
            $wapcm_message_enable = get_option( 'wapcm_message_enable' );
            if ( !empty( $wapcm_message_enable ) && $wapcm_message_enable === 'yes' ) {
                $wapcm_custom_message = get_option( 'wapcm_global_message' );
                $wapcm_message_option_shows_on = ( get_option( 'wapcm_message_option_shows_on' ) ? get_option( 'wapcm_message_option_shows_on' ) : array() );
                if ( is_product() && !in_array( 'product-details-page', $wapcm_message_option_shows_on ) ) {
                    return;
                }
                if ( (is_shop() || is_product_category() || is_product_tag() || is_tax()) && !in_array( 'shop-and-archive-pages', $wapcm_message_option_shows_on ) ) {
                    return;
                }
                if ( !empty( trim( $wapcm_custom_message ) ) ) {
                    echo '<p class="wapcm-message">' . wp_kses_post( $wapcm_custom_message ) . '</p>';
                }
            }
        }
    }

    /**
     * Show custom message.
     *
     * @since    1.0.0
     */
    public function wapcm_woocommerce_template_loop_custom_message( $product ) {
        $product_id = $product->get_id();
        if ( $product_id ) {
            $wapcm_message_enable = get_option( 'wapcm_message_enable' );
            if ( !empty( $wapcm_message_enable ) && $wapcm_message_enable === 'yes' ) {
                $wapcm_custom_message = get_option( 'wapcm_global_message' );
                $wapcm_message_option_shows_on = ( get_option( 'wapcm_message_option_shows_on' ) ? get_option( 'wapcm_message_option_shows_on' ) : array() );
                if ( is_product() && !in_array( 'product-details-page', $wapcm_message_option_shows_on ) ) {
                    return;
                }
                if ( (is_shop() || is_product_category() || is_product_tag() || is_tax()) && !in_array( 'shop-and-archive-pages', $wapcm_message_option_shows_on ) ) {
                    return;
                }
                if ( !empty( trim( $wapcm_custom_message ) ) ) {
                    return '<p class="wapcm-message">' . wp_kses_post( $wapcm_custom_message ) . '</p>';
                }
            }
        }
    }

    /**
     * Show login register button.
     *
     * @since    1.0.0
     */
    public function wapcm_woocommerce_template_single_login_register_button() {
        global $product;
        $product_id = $product->get_id();
        if ( $product_id ) {
            $wapcm_enable_catelog_mode_for = get_option( 'wapcm_enable_catelog_mode_for' );
            $wapcm_show_login_reg_button = get_option( 'wapcm_show_login_reg_button' );
            if ( isset( $wapcm_show_login_reg_button ) && !empty( $wapcm_show_login_reg_button ) && $wapcm_show_login_reg_button === 'yes' && !empty( $wapcm_enable_catelog_mode_for ) && $wapcm_enable_catelog_mode_for == 'hide-only-for-visitor' || !empty( $wapcm_enable_catelog_mode_for ) && $wapcm_enable_catelog_mode_for == 'hide-by-user-role' && !is_user_logged_in() ) {
                echo wp_kses_post( $this->wapcm_get_login_reg_button() );
            }
        }
    }

    /**
     * Get Login/Register button.
     *
     * @since    1.0.0
     */
    public function wapcm_get_login_reg_button() {
        $wapcm_login_reg_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
        $wapcm_login_regi_page_url = apply_filters( 'wapcm_login_reg_page_url_filter', $wapcm_login_reg_page_url );
        $wapcm_login_reg_button_text = __( 'Login / Register', 'product-catalog-mode-for-woocommerce' );
        $wapcm_login_regi_button_text = apply_filters( 'wapcm_login_reg_button_text_filter', $wapcm_login_reg_button_text );
        return '<a href="' . esc_url( $wapcm_login_regi_page_url ) . '" class="wcuo-login-button button" title="' . esc_attr( $wapcm_login_regi_button_text ) . '">' . esc_html( $wapcm_login_regi_button_text ) . '</a>';
    }

}
