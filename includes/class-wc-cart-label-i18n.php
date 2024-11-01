<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       zworthkey.com/about-us
 * @since      1.0.0
 *
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Cart_Label
 * @subpackage Wc_Cart_Label/includes
 * @author     Zworthkey <sales@zworthkey.com>
 */
class Wc_Cart_Label_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-cart-label',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
