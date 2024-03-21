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
		add_action( 'init', 				[ $this, 'enqueue_assets' 	] );
		add_action( 'after_setup_theme', 	[ $this, 'editor_style'		] );
	}

    /**
	 * Skin Assets
	 */
	public function enqueue_assets() {
		wecodeart( 'assets' )->add_script( $this->make_handle(), [
			'path' => self::get_file( 'js', 'frontend' ),
			'deps' => [ 'wecodeart-support-assets' ]
		] );
		
		wecodeart( 'assets' )->add_style( $this->make_handle(), [
			'path' => self::get_file( 'css', 'frontend' )
		] );
	}

	/**
	 * Editor Assets
	 */
	public function editor_style() {
		add_editor_style( self::get_file( 'css', 'frontend' ) );
	}

	/**
	 * Get File
	 */
	public static function get_file( $type, $name ) {
		$file_path = wecodeart_if( 'is_dev_mode' ) ? 'unminified' : 'minified';
		$file_path .= '/' . strtolower( $type ) . '/';
		$file_path .= wecodeart_if( 'is_dev_mode' ) ? $name . '.' . $type :  $name . '.min.' . $type;

		return esc_url( get_stylesheet_directory_uri() . '/assets/' . $file_path );
	}
}