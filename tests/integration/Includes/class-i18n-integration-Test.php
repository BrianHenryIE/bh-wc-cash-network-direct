<?php
/**
 * Tests for I18n. Tests load_plugin_textdomain.
 *
 * @package brianhenryie/bh-wc-cnd-everflow
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_CND_Everflow\Includes;

/**
 * Class BH_WC_CND_Everflow_Test
 *
 * @see I18n
 */
class I18n_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * AFAICT, this will fail until a translation has been added.
	 *
	 * @see load_plugin_textdomain()
	 * @see https://gist.github.com/GaryJones/c8259da3a4501fd0648f19beddce0249
	 */
	public function test_load_plugin_textdomain() {

		$this->markTestSkipped( 'Needs one translation before test might pass.' );

		global $plugin_root_dir;

		$this->assertTrue( file_exists( $plugin_root_dir . '/Languages/' ), '/Languages/ folder does not exist.' );

		// Seems to fail because there are no translations to load.
		$this->assertTrue( is_textdomain_loaded( 'bh-wc-cnd-everflow' ), 'i18n text domain not loaded.' );

	}

}
