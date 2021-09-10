<?php

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

use BrianHenryIE\WC_CND_Everflow\Settings;
use WC_Integration;

class Settings_Page extends WC_Integration {

	public $id = 'bh_wc_cnd_everflow';

	/**
	 * Initialize the integration.
	 */
	public function __construct() {

		$this->method_title       = __( 'Everflow (Cash Network Direct)', 'bh-wc-cnd-everflow' );
		$this->method_description = sprintf(
			__( 'An integration for Cash Network Direct Everflow tracking. [<a target="_blank" href="%1$s">Setup Instructions</a>] [<a target="_blank" href="%2$s">Support</a>] [<a target="_blank" href="%3$s">Login</a>]', 'bh-wc-cnd-everflow' ),
			esc_url( 'https://helpdesk.everflow.io/en/articles/3888434-woocommerce-conversion-tracking-setup' ),
			esc_url( 'https://helpdesk.everflow.io/' ),
			esc_url( 'https://cndirect.everflowclient.io/' )
		);

		$this->init_form_fields();
		$this->init_settings();

		/**
		 * @see WC_Settings_API::process_admin_options()
		 */
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

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

}
