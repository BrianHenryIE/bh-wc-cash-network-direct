<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package brianhenryie/bh-wc-cnd-everflow
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_CND_Everflow;

use BrianHenryIE\WC_CND_Everflow\Includes\BH_WC_CND_Everflow;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_wc_cnd_everflow', $GLOBALS );

		$this->assertInstanceOf( BH_WC_CND_Everflow::class, $GLOBALS['bh_wc_cnd_everflow'] );
	}

}
