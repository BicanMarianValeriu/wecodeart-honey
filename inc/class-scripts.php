<?php
/**
 * WeCodeArt Doc 
 *
 * @package		WeCodeArt Doc 
 * @subpackage	Scripts
 * @copyright	Copyright (c) 2021, WeCodeArt Doc
 * @link		https://www.wecodeart.com/
 * @since		1.0.0
 */

namespace WeCodeArt\Doc;

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
		add_action( 'wp_enqueue_scripts', 	[ $this, 'google_font' ] );
		add_action( 'wp_enqueue_scripts',	[ $this, 'enqueue_scripts_styles' 	], 0 );
		
		add_filter( 'wecodeart/filter/core/scripts/localize', [ $this, 'localize' ] );
		add_filter( 'wecodeart/filter/head/clean', '__return_true' );
	}

	/**
	 * Localize
	 */
	public function localize( $args ) { 
		$args['nonce']		= wp_create_nonce( 'wecodeart-ajax' );
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
	 * Google Fonts
	 */
	public function google_font() {
		$google_fonts = [
			'roboto' 	=> 'Roboto:300,400',
			'opensans' 	=> 'Open+Sans:300,500,700',

		];
	  
		$query_args = [
			'family' => implode( '|', $google_fonts ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		];
	
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	
		wp_enqueue_style( 'google-fonts', esc_url( $fonts_url ), [], wecodeart( 'version' ) );
	}
}