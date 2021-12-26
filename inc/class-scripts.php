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

/**
 * Scripts
 */
class Scripts {

	use \WeCodeArt\Singleton;
	use \WeCodeArt\Core\Scripts\Base;

	/**
	 * Send Construtor
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', 	[ $this, 'enqueue_font' ] );
		add_action( 'after_setup_theme', 	[ $this, 'admin_fonts' ] );
		add_action( 'wp_enqueue_scripts',	[ $this, 'enqueue_scripts_styles' 	], 20 );
		
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
	public function enqueue_scripts_styles() {
		$styles = wecodeart( 'integrations' )->get( 'styles' )::get_instance();

		$styles->Utilities->load( [
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
			'dependencies'	=> [ 'jquery', 'wecodeart-core-scripts' ],
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
	 * Front Fonts
	 */
	public function enqueue_font() {
		wp_enqueue_style( 'google-fonts', $this->get_fonts_url(), [], wecodeart( 'version' ) );
	}

	/**
	 * Admin Fonts
	 */
	public function admin_fonts() {
		add_editor_style( $this->get_fonts_url() );
	}

	/**
	 * Get Fonts URL
	 */
	public function get_fonts_url() {
		$google_fonts = [
			'opensans' 	=> 'Open+Sans:300,500,700',
			// 'opensansc'	=> 'Open+Sans+Condensed:700',
			'signika'	=> 'Signika:700,900',
		];
	  
		$query_args = [
			'family' => implode( '|', $google_fonts ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		];
	
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return str_replace( ',', '%2C', $fonts_url );
	}
}