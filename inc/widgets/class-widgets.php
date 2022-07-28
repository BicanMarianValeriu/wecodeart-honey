<?php
/**
 * WeCodeArt Honey 
 *
 * @package 	WeCodeArt Honey 
 * @subpackage 	Widgets
 * @copyright   Copyright (c) 2021, WeCodeArt Honey
 * @since		1.0.0
 */

namespace WeCodeArt\Honey;

defined( 'ABSPATH' ) || exit();

use WeCodeArt\Singleton;

/**
 * Widgets
 */
class Widgets {

	use Singleton;

	/**
	 * Send to Constructor
	 */
	public function init() {
		add_shortcode( 'wecodeart-stats', 		[ $this, 'render'		] );
		add_shortcode( 'wecodeart-decoration', 	[ $this, 'render_svg'	] );
	}

	/**
	 * SVG
	 *
	 * @return void
	 */
	public function render_svg( $attrs ) {
		$attrs = shortcode_atts( [
		], $attrs, 'wecodeart-decoration' );

        return wecodeart_template( 'general/bee', $attrs, false );
	}

	/**
	 * Releases
	 *
	 * @return void
	 */
	public function render( $attrs ) {
		$attrs = shortcode_atts( [
			'link'			=> [
				'label' 	=> __( 'read documentation', 'wecodeart-docs' ),
				'link'		=> 'https://support.wecodeart.com/documents/wecodeart-framework/',
			]
		], $attrs, 'wecodeart-stats' );

		if( false === ( $transient = get_transient( 'wecodeart/stats' ) ) ) {  
			$api_url = add_query_arg( [
				'action' 		=> 'theme_information',
				'request[slug]'	=> 'wecodeart',
			], esc_url_raw( 'https://api.wordpress.org/themes/info/1.1/' ) ); 
		
			if( ! is_wp_error( $request = wp_remote_get( $api_url ) ) ) { 
				$transient = json_decode( wp_remote_retrieve_body( $request ), true );
				set_transient( 'wecodeart/stats', $transient, 3 * HOUR_IN_SECONDS ); 
			}  
		}
		
		$tooltip = sprintf( __( 'Latest Version: %s', 'am2' ), '<b>' . esc_html( $transient['version'] ) . '</b>' );
		$tooltip .= '<br>' . sprintf( __( 'Updated: %s', 'am2' ), '<b>' . esc_html( $transient['last_updated'] ) . '</b>' );
		$tooltip .= '<br>' . sprintf( __( 'Downloads No: %s', 'am2' ), '<b>' . esc_html( $transient['downloaded'] ) . '</b>' );

		$attrs = wp_parse_args( [
			'button'		=> [
				'label' 	=> __( 'Download Now', 'wecodeart-docs' ),
				'link'		=> $transient['download_link'],
				'tooltip'	=> $tooltip,
			],
		], $attrs );

        return wecodeart_template( 'general/stats', $attrs, false );
	}
}