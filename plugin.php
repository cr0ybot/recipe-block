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

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/init.php';
