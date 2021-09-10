<?php

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

use BrianHenryIE\WC_CND_Everflow\Frontend\Frontend;
use BrianHenryIE\WC_CND_Everflow\Settings;

class ThankYou {

	protected Settings $settings;

	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * @hooked woocommerce_thankyou
	 *
	 * @param int $order_id The WooCommerce order id.
	 */
	public function custom_tracking( int $order_id ): void {

		if ( ! $this->settings->is_configured() ) {
			return;
		}

		// Let's grab the order.
		$order = wc_get_order( $order_id );

		if ( ! ( $order instanceof \WC_Order ) ) {
			return;
		}

		$aid           = $this->settings->get_advertiser_id();
		$amount        = $order->get_total() - $order->get_shipping_total();
		$coupons       = implode( ',', $order->get_coupon_codes() );
		$billing_email = $order->get_billing_email();

		list( $adv1, $adv2, $adv3, $adv4, $adv5 ) = apply_filters( 'bh_wc_cnd_eveflow_adv', array( '', '', '', '', '' ) );

		$script = <<<EOD
EF.conversion({
    aid: $aid,
    amount: $amount,
    order_id: "$order_id",
    coupon_code: "$coupons",
    adv1: "$adv1",
    adv2: "$adv2",
    adv3: "$adv3",
    adv4: "$adv4",
    adv5: "$adv5",
    email: "$billing_email",
});
EOD;

		/**
		 * This will add the above script in WordPress immediately after the 'cash-network-direct-remote' script.
		 *
		 * @see Frontend::enqueue_scripts()
		 */
		wp_add_inline_script(
			'cash-network-direct-remote',
			$script
		);

	}
}
