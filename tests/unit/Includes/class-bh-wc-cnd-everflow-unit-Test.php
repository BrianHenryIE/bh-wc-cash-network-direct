<?php
/**
 * @package brianhenryie/bh-wc-cnd-everflow
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_CND_Everflow\Includes;

use BrianHenryIE\WC_CND_Everflow\Admin\Admin;
use BrianHenryIE\WC_CND_Everflow\Admin\Plugins_Page;
use BrianHenryIE\WC_CND_Everflow\Frontend\Frontend;
use BrianHenryIE\WC_CND_Everflow\Settings;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class BH_WC_CND_Everflow_Unit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_CND_Everflow\Includes\BH_WC_CND_Everflow
 */
class BH_WC_CND_Everflow_Unit_Test extends \Codeception\Test\Unit {

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
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		$settings = $this->makeEmpty( Settings::class );
		new BH_WC_CND_Everflow( $settings );
	}

	/**
	 * @covers ::define_plugins_page_hooks
	 */
	public function test_admin_hooks() {

		$plugin_basename = 'bh-wc-cnd-everflow/bh-wc-cnd-everflow.php';

		\WP_Mock::expectFilterAdded(
			"plugin_action_links_{$plugin_basename}",
			array( new AnyInstance( Plugins_Page::class ), 'action_links' ),
			10,
			4
		);

		\WP_Mock::expectFilterAdded(
			'plugin_row_meta',
			array( new AnyInstance( Plugins_Page::class ), 'row_meta' ),
			10,
			4
		);

		$settings = $this->makeEmpty( Settings::class );
		new BH_WC_CND_Everflow( $settings );
	}

	/**
	 * @covers ::define_frontend_hooks
	 */
	public function test_frontend_hooks() {

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_scripts' )
		);

		$settings = $this->makeEmpty( Settings::class );
		new BH_WC_CND_Everflow( $settings );
	}

}
