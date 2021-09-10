<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\Includes;

use BrianHenryIE\WC_CND_Everflow\Admin\Plugins_Page;
use BrianHenryIE\WC_CND_Everflow\Frontend\Frontend;
use BrianHenryIE\WC_CND_Everflow\Settings;
use BrianHenryIE\WC_CND_Everflow\WooCommerce\Register_Settings_Integration;
use BrianHenryIE\WC_CND_Everflow\WooCommerce\Settings_Page;
use BrianHenryIE\WC_CND_Everflow\WooCommerce\ThankYou;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    brianhenryie/bh-wc-cnd-everflow
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class BH_WC_CND_Everflow {

	/**
	 * The advertiser id and tracking domain, as entered in the WooCommerce settings UI.
	 *
	 * @used-by Frontend::enqueue_scripts()
	 * @used-by ThankYou::conversion_tracking()
	 *
	 * @var Settings The plugin's settings.
	 */
	protected Settings $settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param Settings $settings The plugin's settings.
	 */
	public function __construct( Settings $settings ) {

		$this->settings = $settings;

		$this->set_locale();

		$this->define_plugins_page_hooks();
		$this->defined_woocommerce_settings_page_hooks();

		$this->define_frontend_hooks();
		$this->define_woocommerce_thankyou_page_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'init', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Adds links on plugins.php to the Settings page, and to the Everflow Support and Login.
	 *
	 * @since    1.0.0
	 */
	protected function define_plugins_page_hooks(): void {

		$plugins_page = new Plugins_Page();

		$plugin_basename = 'bh-wc-cnd-everflow/bh-wc-cnd-everflow.php';

		add_filter( "plugin_action_links_{$plugin_basename}", array( $plugins_page, 'action_links' ), 10, 4 );
		add_filter( 'plugin_row_meta', array( $plugins_page, 'row_meta' ), 10, 4 );
	}

	/**
	 * Registers the settings page with WooCommerce which later instantiates it.
	 *
	 * @see Settings_Page
	 *
	 * @since    1.0.0
	 */
	protected function defined_woocommerce_settings_page_hooks(): void {

		$register_settings_integration = new Register_Settings_Integration();

		add_filter( 'woocommerce_integrations', array( $register_settings_integration, 'add_integration' ) );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	protected function define_frontend_hooks(): void {

		$plugin_frontend = new Frontend( $this->settings );

		add_action( 'wp_enqueue_scripts', array( $plugin_frontend, 'enqueue_scripts' ) );
	}

	/**
	 * Adds the order details to the JavaScript and outputs it on the order confirmation page.
	 *
	 * @since    1.0.0
	 */
	protected function define_woocommerce_thankyou_page_hooks(): void {

		$thankyou = new ThankYou( $this->settings );

		add_action( 'woocommerce_thankyou', array( $thankyou, 'conversion_tracking' ) );
	}
}
