<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       zworthkey.com/about-us
 * @since      1.0.0
 *
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/admin
 * @author     Zworthkey <sales@zworthkey.com>
 */
class Wc_Cart_Label_Admin {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/zwk-customize-discount-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-cart-label-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_filter( 'woocommerce_get_sections_products', array( $this, 'wccl_add_label' ) );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'wccl_add_items' ), 10, 2 );

	}


	public function wccl_add_label( $section ) {
		$section['wccl_add_label'] = __( 'WC Cart Label' );
		return $section;
	}


	public function wccl_add_items( $settings, $current_section ) {
		if ( 'wccl_add_label' === $current_section ) {

			$products    = wc_get_product_types(); // Get all the available products in woocommerce
			$add_items[] = array(
				'title' => __( 'Change the Add to cart Button form Store as well as Single Product Pages' ),
				'type'  => 'title',
				'id'    => 'label_change'
			);
			foreach ( $products as $product => $item ) {
				$add_items[] = array(
					'title'       => __( $item . ' (Single page)' ),
					'desc'        => __( $item . ' Page' ),
					'desc_tip'    => __( 'This will change the "add to cart" label shown on single page of type ' . strtolower( $item )  ),
					'id'          => $product . '_button_text_single',
					'type'        => 'text',
					'placeholder' => 'Add to cart',
					'css'         => 'max-width:250px;',
				);
				$add_items[] = array(
					'desc'        => 'Store Page',
					'desc_tip'    => __( 'This will change the "add to cart" label shown on ' . strtolower( $item ) . 'at store page'),
					'title'       => __( $item . ' (archive)' ),
					'id'          => $product . '_button_text',
					'type'        => 'text',
					'placeholder' => 'Add to cart',
					'css'         => 'max-width:250px;',
				);
			}
			$add_items[] = array( 'type' => 'sectionend', 'id' => 'wc-save-settings_1' );
			return $add_items;
		} else {
			return $settings;
		}
	}

}
