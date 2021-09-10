<?php
/**
 * The plugins settings.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow;

use BrianHenryIE\WC_CND_Everflow\Frontend\Frontend;
use BrianHenryIE\WC_CND_Everflow\WooCommerce\ThankYou;

/**
 * A facade over the WooCommerce managed settings.
 *
 * @see \WC_Settings_API
 */
class Settings {

	const OPTION_NAME = 'woocommerce_bh_wc_cnd_everflow_settings';

	const ADVERTISING_ID_SETTING_NAME  = 'advertiser_id';
	const TRACKING_DOMAIN_SETTING_NAME = 'tracking_domain';

	/**
	 * WooCommerce stores all the settings under on option key. Fetch it here for the public methods to use.
	 *
	 * @see @see \WC_Settings_API::get_option_key()
	 *
	 * @return array{advertiser_id: ?string, tracking_domain: ?string}
	 */
	protected function get_all_options(): array {
		return get_option( self::OPTION_NAME, array() );
	}

	/**
	 * Quick check to see have the settings being entered.
	 * Used so the JavaScript is not loaded when it cannot be useful.
	 *
	 * @used-by Frontend::enqueue_scripts()
	 * @used-by ThankYou::conversion_tracking()
	 *
	 * @return bool
	 */
	public function is_configured(): bool {
		$all_options = $this->get_all_options();
		return isset( $all_options[ self::ADVERTISING_ID_SETTING_NAME ] ) && isset( $all_options[ self::TRACKING_DOMAIN_SETTING_NAME ] );
	}

	/**
	 * The company's ID with Everflow.
	 *
	 * @return string|null
	 */
	public function get_advertiser_id(): ?string {

		$all_options = $this->get_all_options();

		if ( isset( $all_options[ self::ADVERTISING_ID_SETTING_NAME ] ) ) {
			return $all_options[ self::ADVERTISING_ID_SETTING_NAME ];
		}

		return null;
	}

	/**
	 * Each advertiser loads the JavaScript from a different domain name.
	 *
	 * @return ?string
	 */
	public function get_tracking_domain(): ?string {

		$all_options = $this->get_all_options();

		if ( isset( $all_options[ self::TRACKING_DOMAIN_SETTING_NAME ] ) ) {
			return $all_options[ self::TRACKING_DOMAIN_SETTING_NAME ];
		}

		return null;

	}

}
