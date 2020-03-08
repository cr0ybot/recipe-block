<?php
/**
 * Plugin Name: Recipetron
 * Plugin URI: https://github.com/cr0ybot/recipetron/
 * Description: Add recipes to your posts as a Gutenberg block.
 * Author: Cory Hughart
 * Author URI: https://coryhughart.com/
 * Version: 0.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package recipetron
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RECIPETRON_VERSION', '0.1.0' );

/**
 * Main plugin class
 *
 * Loads plugin dependencies
 *
 * @since 1.0.0
 * @package recipetron
 */
final class Recipetron {
	const SLUG = 'recipetron';
	const PREFIX  = 'Recipetron';

	private static $instance;
	public static $dir = '';
	public static $url = '';

	public $blocks;

	public static function instance() {
		if (!isset(self::$instance) && !(self::$instance instanceof Recipetron)) {
			self::$instance = new Recipetron();
			self::$dir = plugin_dir_path(__FILE__);
			self::$url = plugin_dir_url(__FILE__);
		}

		return self::$instance;
	}

	protected function __construct() {
		spl_autoload_register(array(&$this, 'autoloader'));

		$this->load_dependencies();
	}

	private function load_dependencies() {
		// Blocks
		$this->blocks = new Recipetron_Blocks();
	}

	public function autoloader( $class_name ) {
		if ( class_exists( $class_name ) ) return;
		if ( false === strpos( $class_name, self::PREFIX ) ) return;

		// Convert class name format to file name format
		$class_file = strtolower( $class_name );
		$class_file = str_replace( '_', '-', $class_file );

		require_once __DIR__ . '/includes/class-' . $class_file . '.php';
	}
}

function Recipetron() {
	return Recipetron::instance();
}

Recipetron();
