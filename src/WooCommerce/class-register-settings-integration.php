<?php
/**
 * Register the settings page to appear WooCommerce / Settings / Integrations / Everflow.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

/**
 * Simple filter to tell WooCommerce which class to instantiate.
 *
 * @see \WC_Integration
 */
class Register_Settings_Integration {

	/**
	 * Add the integration to WooCommerce.
	 *
	 * @hooked woocommerce_integrations
	 * @see \WC_Integrations
	 *
	 * @param string[] $integrations The existing integrations.
	 * @return string[]
	 */
	public function add_integration( array $integrations ): array {
		$integrations[] = Settings_Page::class;
		return $integrations;
	}

}
