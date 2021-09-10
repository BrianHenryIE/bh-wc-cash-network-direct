<?php
/**
 * Register the settings page to appear WooCommerce / Settings / Integrations / Everflow.
 */

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

/**
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
