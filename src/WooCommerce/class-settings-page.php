<?php
/**
 * Adds a section "Everflow (Cash Network Direct)" under the Integrations tab of WooCommerce Settings.
 *
 * Contains two settings: Advertiser ID and Tracking Domain.
 *
 * Validates the input.
 *
 * @see admin.php?page=wc-settings&tab=integration&section=bh_wc_cnd_everflow
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

use BrianHenryIE\WC_CND_Everflow\Settings;
use Exception;
use WC_Integration;

/**
 * Defines the settings fields and validators.
 *
 * @see \WC_Settings_API
 */
class Settings_Page extends WC_Integration {

	/**
	 * Initialize the integration.
	 * WC_Settings_API::process_admin_options()
	 */
	public function __construct() {

		$this->id                 = 'bh_wc_cnd_everflow';
		$this->method_title       = __( 'Everflow (Cash Network Direct)', 'bh-wc-cnd-everflow' );
		$this->method_description = sprintf(
			/* translators: Independent sentence followed by three links. */
			__( 'An integration for Cash Network Direct Everflow tracking. [<a target="_blank" href="%1$s">Setup Instructions</a>] [<a target="_blank" href="%2$s">Support</a>] [<a target="_blank" href="%3$s">Login</a>]', 'bh-wc-cnd-everflow' ),
			esc_url( 'https://helpdesk.everflow.io/en/articles/3888434-woocommerce-conversion-tracking-setup' ),
			esc_url( 'https://helpdesk.everflow.io/' ),
			esc_url( 'https://cndirect.everflowclient.io/' )
		);

		$this->init_form_fields();
		$this->init_settings();

		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'admin_notices', array( $this, 'display_errors' ) );
	}

	/**
	 * Initializes the settings fields.
	 *
	 * @see https://helpdesk.everflow.io/en/articles/3888434-woocommerce-conversion-tracking-setup
	 *
	 * @see \WC_Settings_API::init_form_fields()
	 *
	 * @return void
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			Settings::ADVERTISING_ID_SETTING_NAME  => array(
				'title'       => __( 'Advertiser ID', 'bh-wc-cnd-everflow' ),
				'type'        => 'text',
				'description' => __(
					'The advertiser id  found under Offers > Manage > Click the Offer Page.',
					'bh-wc-cnd-everflow'
				),
				'desc_tip'    => false,
				'default'     => '',
			),
			Settings::TRACKING_DOMAIN_SETTING_NAME => array(
				'title'       => __( 'Tracking Domain', 'bh-wc-cnd-everflow' ),
				'type'        => 'text',
				'description' =>
					__(
						'The tracking domain found under Offers > Manage > Click the Offer in the JavaScript SDK section.',
						'bh-wc-cnd-everflow'
					),
				'desc_tip'    => false,
				'default'     => '',
			),
		);
	}

	/**
	 * Checks the advertising id is an integer.
	 *
	 * @see Settings::ADVERTISING_ID_SETTING_NAME
	 *
	 * @param string $key "advertiser_id".
	 * @param string $value As entered by the user.
	 * @return string
	 * @throws Exception When validation fails.
	 */
	public function validate_advertiser_id_field( $key, $value ) {

		$validated = intval( $value );
		if ( "{$validated}" !== $value ) {
			throw new Exception( 'Advertiser id should be a number. You entered: "' . $value . '".' );
		}

		return $value;
	}

	/**
	 * Parses the input for the raw domain (http://example.com/asd -> example.com)
	 * then checks the JavaScript is available at that domain.
	 *
	 * @see Settings::TRACKING_DOMAIN_SETTING_NAME
	 *
	 * @param string $key "tracking_domain".
	 * @param string $value The domain entered by the user.
	 * @return string
	 * @throws Exception When invalid domain or JavaScript is not found at that address.
	 */
	public function validate_tracking_domain_field( $key, $value ) {

		if ( empty( $value ) ) {
			return '';
		}

		if ( 1 !== preg_match( '/(https?:\/\/)?([^\/$]*)/', $value, $output_array ) ) {
			throw new Exception( 'Invalid URL. You entered: "' . $value . '".' );
		}

		$domain = (string) $output_array[2];

		$js_url = "https://{$domain}/scripts/sdk/everflow.js";

		if ( false === wp_http_validate_url( $js_url ) ) {
			throw new Exception( 'Invalid URL. You entered: "' . $value . '".' );
		}

		$request = wp_remote_get( $js_url );

		if ( is_wp_error( $request ) ) {
			$error_message = $request->get_error_message();
			throw new Exception( "Error {$error_message} testing URL {$js_url}. You entered: {$value}. Please try again." );
		}

		$response_code = $request['response']['code'];
		if ( 200 !== $response_code ) {
			throw new Exception( "Error {$response_code} fetching URL {$js_url}. You entered: {$value}. Please check the domain is correct and try again." );
		}

		return $domain;
	}
}
