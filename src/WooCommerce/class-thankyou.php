<?php
/**
 * Enqueues the script to record the conversion after checkout is complete.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\WooCommerce;

use BrianHenryIE\WC_CND_Everflow\Frontend\Frontend;
use BrianHenryIE\WC_CND_Everflow\Settings;

/**
 * Checks are the settings present, output order details into JavaScript to be fired on page load.
 */
class ThankYou {

	/**
	 * Used to check are the settings configured.
	 *
	 * @var Settings
	 */
	protected Settings $settings;

	/**
	 * Thank you page conversion recording.
	 *
	 * @param Settings $settings The plugin settings.
	 */
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Adds order details to the conversion tracking JavaScript and enqueues it after the main JS file.
	 *
	 * @hooked woocommerce_thankyou
	 * @see woocommerce/templates/checkout/thankyou.php
	 *
	 * @param int $order_id The WooCommerce order id.
	 */
	public function conversion_tracking( int $order_id ): void {

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

		list( $adv1, $adv2, $adv3, $adv4, $adv5 ) = apply_filters( 'bh_wc_cnd_eveflow_thankyou', array( '', '', '', '', '' ) );

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
