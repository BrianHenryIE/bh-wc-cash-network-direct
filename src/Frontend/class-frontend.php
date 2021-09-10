<?php
/**
 * The public-facing functionality of the plugin.
 *
 * * Checks are the settings configured
 * * Enqueues the JavaScript from the server and local JavaScript.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\Frontend;

use BrianHenryIE\WC_CND_Everflow\Settings;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend-facing stylesheet and JavaScript.
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Frontend {

	/**
	 * The plugin settings.
	 *
	 * @see Settings::get_tracking_domain()
	 *
	 * @var Settings
	 */
	protected Settings $settings;

	/**
	 * The plugin frontend code.
	 *
	 * @param Settings $settings The plugin's settings, as set in WooCommerce/Settings/Integrations/Everflow.
	 */
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Register the JavaScript for the frontend-facing side of the site.
	 *
	 * This enqueues the scripts both on regular pages and on the thank you page.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		if ( ! $this->settings->is_configured() ) {
			return;
		}

		$tracking_domain = $this->settings->get_tracking_domain();

        // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_script( 'cash-network-direct-remote', "https://{$tracking_domain}/scripts/sdk/everflow.js", array(), null, true );

		$version = defined( 'BH_WC_CND_EVERFLOW_VERSION' ) ? BH_WC_CND_EVERFLOW_VERSION : '1.0.0';
		wp_enqueue_script( 'cash-network-direct-click', plugin_dir_url( __FILE__ ) . 'js/bh-wc-cnd-everflow-frontend.js', array( 'cash-network-direct-remote' ), $version, true );

	}

}
