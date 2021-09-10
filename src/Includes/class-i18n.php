<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://BrianHenryIE.com
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-cnd-everflow
 */

namespace BrianHenryIE\WC_CND_Everflow\Includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    brianhenryie/bh-wc-cnd-everflow
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @hooked plugins_loaded
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void {

		load_plugin_textdomain(
			'bh-wc-cnd-everflow',
			false,
			plugin_basename( dirname( __FILE__, 2 ) ) . '/languages/'
		);

	}

}
