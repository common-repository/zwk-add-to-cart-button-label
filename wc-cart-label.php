<?php

/**
 *
 * @link              zworthkey.com/about-us
 * @since             1.0.0
 * @package           Wc_Cart_Label
 *
 * @wordpress-plugin
 * Plugin Name:       Cart Label
 * Plugin URI:        zworthkey.com
 * Description:       This Plugin will allow the user to customize the default text of woocommerce cart ‘Add to Cart’ to any of its liking.
 * Version:           1.0.0
 * Author:            Zworthkey
 * Author URI:        zworthkey.com/about-us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-cart-label
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_action( 'admin_notices', 'wccl_general_admin_notice' );
	return;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_CART_LABEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-cart-label-activator.php
 */
function activate_wc_cart_label() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-cart-label-activator.php';
	Wc_Cart_Label_Activator::activate();
}


function wccl_general_admin_notice() {
	echo '<div class="notice notice-error  ">
             <p>woocommerce is not activate! It should be active to Use the plugin.</p>
         </div>';
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-cart-label-deactivator.php
 */
function deactivate_wc_cart_label() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-cart-label-deactivator.php';
	Wc_Cart_Label_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_cart_label' );
register_deactivation_hook( __FILE__, 'deactivate_wc_cart_label' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-cart-label.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_cart_label() {

	$plugin = new Wc_Cart_Label();
	$plugin->run();
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wccl_add_action_links' );

}
run_wc_cart_label();
function wccl_add_action_links( $actions ) {
	$mylinks = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=products&section=wccl_add_label' ) . '">Settings</a>',
	);
	$actions = array_merge( $mylinks, $actions );

	return $actions;
}