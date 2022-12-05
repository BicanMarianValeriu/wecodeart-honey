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
		add_action( 'after_setup_theme', 	[ $this, 'admin_fonts' 		] );
		add_action( 'wp_enqueue_scripts',	[ $this, 'enqueue_assets'	] );
		
		add_filter( 'wecodeart/filter/scripts/localize', [ $this, 'localize' ] );
	}

	/**
	 * Localize
	 */
	public function localize( $args ) { 
		$args['REST']		= esc_url_raw( rest_url() );
		$args['ajaxUrl']	= esc_url_raw( admin_url( 'admin-ajax.php' ) );
		return $args;
	}

    /**
	 * Skin Assets
	 */
	public function enqueue_assets() {
		wecodeart( 'styles' )->Utilities->load( [
			'position-fixed',
			'bottom-0',
			'start-0',
			'me-auto',
			'p-3',
		] );
		
		$path = wecodeart_if( 'is_dev_mode' ) ? 'unminified' : 'minified';
		$name = wecodeart_if( 'is_dev_mode' ) ? 'frontend' : 'frontend.min';
		$default = [
			'version' 		=> wecodeart( 'version' ),
			'dependencies'	=> [ 'jquery', 'wecodeart-support-assets' ],
		];

		wp_register_style(
			$this->make_handle(), 
			get_stylesheet_directory_uri() . '/assets/' . $path . '/css/' . $name . '.css',
			[],
			$default['version']
		);

		wp_enqueue_style( $this->make_handle() );

		wp_enqueue_style( $this->make_handle( 'fonts' ) , self::get_fonts_url(), [], wecodeart( 'version' ) );
		
		// JS
		$deps = sprintf( '%s/assets/%s/js/%s.php', get_stylesheet_directory(), $path, '' . $name . '.asset' );
		
		if( is_readable( $deps ) ) {
			$file = require $deps;
			$data = array_merge_recursive( $file, $default );
		}

		wp_register_script( 
			$this->make_handle(),
			get_stylesheet_directory_uri() . '/assets/' . $path . '/js/' . $name . '.js',
			array_merge( $data['dependencies'], [ 'moment', 'lodash' ] ), 
			current( $data['version'] ), 
			true 
		);

		wp_enqueue_script( $this->make_handle() );
	}

	/**
	 * Admin Fonts
	 */
	public function admin_fonts() {
		wp_enqueue_style( 'wp-block-library' );
		wp_add_inline_style( 'wp-block-library', self::load_font_styles() );
	}

	/**
	 * Get Fonts URL
	 */
	public static function get_fonts_url() {
		$google_fonts = [
			'signika'	=> 'Signika:700,900',
		];
	  
		$query_args = [
			'family' => implode( '|', $google_fonts ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
			'display'=> 'swap'
		];
	
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return str_replace( ',', '%2C', $fonts_url );
	}

	/**
	 * Load Font Styles
	 */
	public static function load_font_styles() {
		$fonts_url = self::get_fonts_url();

		return "
			@import url('${fonts_url}');
		";
	}
}