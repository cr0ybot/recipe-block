<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   0.1.0
 * @package recipetron
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 0.1.0
 */
function recipetron_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'recipetron', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array(), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'recipetron-editor', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'recipetron', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `plugin` object.
	wp_localize_script(
		'recipetron',
		'plugin',
		array(
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
		)
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'recipetron/recipe', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'recipetron',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'recipetron',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'recipetron-editor',
		)
	);
}
add_action( 'init', 'recipetron_assets' );

function recipetron_block_category( $categories, $pots ) {

	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'recipetron',
				'title' => __( 'Recipetron', 'recipetron' ),
				'icon'  => '<svg version="1.1" id="recipetron" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><g><path d="M20,10H4v0c0-1.1,0.9-2,2-2h12C19.1,8,20,8.9,20,10L20,10z"/><path d="M20,13v-2H4v2c-1.1,0-2,0.9-2,2h2v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3h2C22,13.9,21.1,13,20,13z M7.5,17 C6.7,17,6,16.3,6,15.5S6.7,14,7.5,14S9,14.7,9,15.5S8.3,17,7.5,17z M14,18h-4v-1h4V18z M16.5,17c-0.8,0-1.5-0.7-1.5-1.5 s0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5S17.3,17,16.5,17z"/><rect x="10" y="5" width="4" height="2"/></g></svg>',
			),
		)
	);
	return $categories;
}
add_filter( 'block_categories', 'recipetron_block_category', 10, 2 );
