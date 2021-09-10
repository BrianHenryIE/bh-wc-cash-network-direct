<?php
/**
 * Tests for Frontend.
 *
 * @see Frontend
 *
 * @package brianhenryie/bh-wc-cnd-everflow
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_CND_Everflow\Frontend;

use BrianHenryIE\WC_CND_Everflow\Settings;

/**
 * Class Frontend_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_CND_Everflow\Frontend\Frontend
 */
class Frontend_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
		parent::setup();
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * Verifies enqueue_scripts() calls wp_enqueue_script() with appropriate parameters.
	 * Verifies the .js file exists.
	 *
	 * @covers ::enqueue_scripts
	 * @see wp_enqueue_script()
	 */
	public function test_enqueue_scripts() {

		global $plugin_root_dir;

		// Return any old url.
		\WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'return' => $plugin_root_dir . '/frontend/',
			)
		);

		$handle    = 'cash-network-direct-remote';
		$src       = 'https://example.com/scripts/sdk/everflow.js';
		$deps      = array();
		$ver       = null;
		$in_footer = true;

		\WP_Mock::userFunction(
			'wp_enqueue_script',
			array(
				'times' => 1,
				'args'  => array( $handle, $src, $deps, $ver, $in_footer ),
			)
		);

		$handle    = 'cash-network-direct-click';
		$src       = $plugin_root_dir . '/frontend/js/bh-wc-cnd-everflow-frontend.js';
		$deps      = array( 'cash-network-direct-remote' );
		$ver       = '1.0.0';
		$in_footer = true;

		\WP_Mock::userFunction(
			'wp_enqueue_script',
			array(
				'times' => 1,
				'args'  => array( $handle, $src, $deps, $ver, $in_footer ),
			)
		);

		$settings = $this->makeEmpty(
			Settings::class,
			array(
				'is_configured'       => true,
				'get_tracking_domain' => 'example.com',
			)
		);
		$frontend = new Frontend( $settings );

		$frontend->enqueue_scripts();

		$this->assertFileExists( $src );
	}
}
