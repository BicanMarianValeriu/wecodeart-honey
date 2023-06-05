<?php
/**
 * WeCodeArt Honey 
 *
 * @package		WeCodeArt Honey 
 * @subpackage	Scripts
 * @copyright	Copyright (c) 2021, WeCodeArt Honey
 * @link		https://www.wecodeart.com/
 * @since		1.0.0
 */

namespace WeCodeArt\Honey;

defined( 'ABSPATH' ) || exit();

use WeCodeArt\Singleton;
use WeCodeArt\Config\Traits\Asset;

/**
 * Scripts
 */
class Scripts {

	use Singleton;
	use Asset;

	/**
	 * Send Construtor
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', 	[ $this, 'enqueue_assets' ], PHP_INT_MAX );
		add_action( 'after_setup_theme', 	[ $this, 'editor_style'	] );
	}

    /**
	 * Skin Assets
	 */
	public function enqueue_assets() {
		$path = wecodeart_if( 'is_dev_mode' ) ? 'unminified' : 'minified';
		$name = wecodeart_if( 'is_dev_mode' ) ? 'frontend' : 'frontend.min';

		$default = [
			'version' 		=> wecodeart( 'version' ),
			'dependencies'	=> [ 'wecodeart-support-assets' ],
		];

		wp_register_style(
			$this->make_handle(), 
			get_stylesheet_directory_uri() . '/assets/' . $path . '/css/' . $name . '.css',
			[],
			$default['version']
		);

		wp_enqueue_style( $this->make_handle() );
		
		// JS
		$deps = sprintf( '%s/assets/%s/js/%s.php', get_stylesheet_directory(), $path, '' . $name . '.asset' );
		
		if( is_readable( $deps ) ) {
			$file = require $deps;
			$data = array_merge_recursive( $file, $default );
		}

		wp_register_script( 
			$this->make_handle(),
			get_stylesheet_directory_uri() . '/assets/' . $path . '/js/' . $name . '.js',
			$data['dependencies'], 
			current( $data['version'] ), 
			true 
		);

		wp_enqueue_script( $this->make_handle() );
	}

	/**
	 * Editor Assets
	 */
	public function editor_style() {
		$path = wecodeart_if( 'is_dev_mode' ) ? 'unminified' : 'minified';
		$name = wecodeart_if( 'is_dev_mode' ) ? 'frontend' : 'frontend.min';

		add_editor_style( get_stylesheet_directory_uri() . '/assets/' . $path . '/css/' . $name . '.css' );
	}
}