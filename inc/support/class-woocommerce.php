<?php
/**
 * WeCodeArt Honey 
 *
 * @package 	WeCodeArt Honey 
 * @subpackage 	Support
 * @copyright   Copyright (c) 2021, WeCodeArt Docs
 * @since		1.0.0
 */

namespace WeCodeArt\Honey\Support;

defined( 'ABSPATH' ) || exit();

use WeCodeArt\Singleton;

/**
 * WooCommerce
 */
class WooCommerce {

	use Singleton;

	/**
	 * Send Construtor
	 */
	public function init() {
		add_filter( 'woocommerce_enqueue_styles',						'__return_empty_array' );
		add_action( 'wp_enqueue_scripts',								[ $this, 'manage_assets' 			] );

		// Title
		add_filter( 'wecodeart/filter/wrappers/wp-block-post-title', 	[ $this, 'title_wrappers' 			] );

		// Columns
		add_filter( 'woocommerce_output_related_products_args', 		[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_upsell_display_args', 					[ $this, 'similar_products_args' 	], 20 );
		add_filter( 'woocommerce_cross_sells_columns', 					[ $this, 'cross_sells_columns' 		], 20 );
		
		// Breadcrumbs
		remove_action( 'woocommerce_before_main_content', 	'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_single_product_summary', 	'woocommerce_breadcrumb', -10 );
		add_filter( 'woocommerce_breadcrumb_defaults',		[ $this, 'breadcrumbs' ] );
	}

	/**
	 * Remove Default Styles
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function manage_assets( $args ) {
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'select2' );
	}

	/**
	 * Cross sells Columns Args
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function cross_sells_columns( $args ) {
		return 3;
	}

	/**
	 * Similar Products Args
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function similar_products_args( $args ) {
		return wp_parse_args( [
			'posts_per_page' 	=> 4,
			'columns' 			=> 4,
		], $args );
	}

	/**
	 * Title Wrappers
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function title_wrappers( $wrappers ) {
		wecodeart( 'styles' )->Utilities->load( 'overflow-hidden' );

		if( isset( $wrappers[0] ) && isset( $wrappers[0]['attrs'] ) ) {
			$wrappers[0]['attrs']['class'] .= ' overflow-hidden';
		}

		return $wrappers;
	}
	
	/**
	 * Breadcrumbs
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	array
	 */
	public function breadcrumbs( $args ) {
		$args['delimiter'] = ' » ';

		return $args;
	}
}