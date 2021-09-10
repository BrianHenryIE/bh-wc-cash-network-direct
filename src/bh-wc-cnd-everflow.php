<?php
/**
 * Advertising conversion tracking for Cash Network Direct Everflow.
 *
 * @see https://helpdesk.everflow.io/en/articles/3888434-woocommerce-conversion-tracking-setup
 *
 * @link              http://BrianHenryIE.com
 * @since             1.0.0
 * @package           brianhenryie/bh-wc-cnd-everflow
 *
 * @wordpress-plugin
 * Plugin Name:       CND Everflow
 * Plugin URI:        http://github.com/BrianHenryIE/bh-wc-cnd-everflow/
 * Description:       Advertising conversion tracking for Cash Network Direct Everflow.
 * Version:           1.1.0
 * Author:            BrianHenryIE
 * Author URI:        https://BrianHenry.ie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-cnd-everflow
 * Domain Path:       /languages
 */

namespace BrianHenryIE\WC_CND_Everflow;

use BrianHenryIE\WC_CND_Everflow\Includes\BH_WC_CND_Everflow;
use Exception;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	throw new Exception( __FILE__ );
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_WC_CND_EVERFLOW_VERSION', '1.1.0' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_cnd_everflow(): BH_WC_CND_Everflow {

	$settings = new Settings();

	$plugin = new BH_WC_CND_Everflow( $settings );

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_wc_cnd_everflow'] = instantiate_bh_wc_cnd_everflow();

