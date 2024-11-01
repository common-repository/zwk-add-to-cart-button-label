<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       zworthkey.com/about-us
 * @since      1.0.0
 *
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/public
 * @author     Zworthkey <sales@zworthkey.com>
 */
class Wc_Cart_Label_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'wccl_added_text_woocommerce_add_to_cart' ) );
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'wccl_added_text_woocommerce_add_to_cart' ) );
		add_filter( 'woocommerce_booking_single_add_to_cart_text', array( $this, 'wccl_added_text_woocommerce_add_to_cart' ) );
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-cart-label-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-cart-label-public.js', array( 'jquery' ), $this->version, false );

	}

	public function wccl_added_text_woocommerce_add_to_cart( $text ) {
		global $product;
		if ( ! isset ( $product ) || ! is_object( $product ) ) {
			return $text;
		}
		$product_type   = $product->get_type();
		$is_single_page = is_product() ? '_single' : '';
		if ( ! empty( $product_type ) ) {
			return __( $options = sanitize_text_field( $this->wccl_existing_option( $product_type . '_button_text' . $is_single_page ) ) );
		}

		return $text;
	}

	public function wccl_existing_option( $key ) {
		$saved = get_option( $key );
		if ( $saved && '' != $saved ) {
			return $saved;
		}

		return 'Add to cart';
	}

}
