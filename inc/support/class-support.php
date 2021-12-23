<?php
/**
 * WeCodeArt Docs 
 *
 * @package 	WeCodeArt Docs 
 * @subpackage 	Support
 * @copyright   Copyright (c) 2021, WeCodeArt Docs
 * @since		1.0.0
 */

namespace WeCodeArt\Doc;

defined( 'ABSPATH' ) || exit();

use function WeCodeArt\Doc\get_popular_documents;

/**
 * Support
 */
class Support {

	use \WeCodeArt\Singleton;

	/**
	 * Send Construtor
	 */
	public function init() {
		add_filter( 'pvc_enqueue_styles', '__return_false' );
		add_filter( 'pvc_most_viewed_posts_html', [ $this, 'render' ], 10, 2 );
	}

	/**
	 * Render
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function render( $html, $args ) {

		$args = array_filter( $args, function( $item ) {
			return( in_array( $item, [ 'post_type', 'order', 'number_of_posts' ] ) );
		} );

		$args['posts_per_page'] = isset( $args['number_of_posts'] ) ? $args['number_of_posts'] : 5;
		unset( $args['number_of_posts'] );

		$html = wecodeart_template( [ 'widgets/document', 'listing' ], [
			'posts' 		=> get_popular_documents( null, null, $args ),
			'icon'			=> 'fad fa-fire me-2 has-danger-color',
			'show_count' 	=> $args['show_post_views'] ?: false,
		], false );
		
		return $html;
	}
}