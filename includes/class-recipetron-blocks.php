<?php
/**
 * Responsible for registering blocks and their assets
 *
 * @since 1.0.0
 * @package recipetron
 */
class Recipetron_Blocks {

	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_action( 'block_categories', array( $this, 'register_block_category' ), 10, 2 );
	}

	public function register() {
		$this->register_assets();
		$this->register_blocks();
	}

	private function register_assets() {
		// Register block styles for both frontend + backend.
		wp_register_style(
			'recipetron',
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
		);

		// Register block editor styles for backend.
		wp_register_style(
			'recipetron-editor',
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
			array( 'wp-edit-blocks' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
		);

		// Register block editor script for backend.
		wp_register_script(
			'recipetron',
			plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
			true
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
	}

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @since 1.0.0
	 */
	private function register_blocks() {
		// Recipe block
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

	public function register_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'recipetron',
					'title' => __( 'Recipetron', 'recipetron' ),
					// Note: icon is set in JS
				),
			)
		);
	}
}
