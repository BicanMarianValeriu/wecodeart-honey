<?php
/**
 * WeCodeArt Honey 
 *
 * @package 	WeCodeArt Honey 
 * @subpackage 	Support
 * @copyright   Copyright (c) 2021, WeCodeArt Docs
 * @since		1.0.0
 */

namespace WeCodeArt\Honey;

defined( 'ABSPATH' ) || exit();

use WeCodeArt\Singleton;

/**
 * Support
 */
class Support {

	use Singleton;

	/**
	 * Send Construtor
	 */
	public function init() {
		// Block Styles
		register_block_style( 'core/list', [
			'name'	=> 'check',
            'label'	=> __( 'Check', 'wecodeart-honey' ),
		] );

		register_block_style( 'core/media-text', [
			'name'	=> 'overlap',
            'label'	=> __( 'Overlap', 'wecodeart-honey' ),
		] );

		// Shortcodes
		add_shortcode( 'wecodeart-decoration', 			[ $this, 'render_svg'	] );

		// City/State delivery
		add_filter( 'woocommerce_states',				[ $this, 'filter_states' ], 10, 1 );
		add_filter( 'default_checkout_billing_state',	[ $this, 'filter_default_state' ] );
		add_filter( 'default_checkout_shipping_state',	[ $this, 'filter_default_state' ] );
	}
	
	/**
	 * Sample
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	array
	 */
	public function sample( $args ) {
		
		return $args;
	}

	/**
	 * SVG
	 *
	 * @return void
	 */
	public function render_svg( $attrs ) {
		$attrs = shortcode_atts( [
		], $attrs, 'wecodeart-decoration' );

        return wecodeart_template( 'bee-maskot', $attrs, false );
	}

	/**
	 * City/State delivery
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	void
	 */
	public function filter_states( $states ) {
		return [
			'RO' => [
				'GJ' => 'Gorj'
			]
		];
	}

	/**
	 * State
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function filter_default_state() {
		return 'GJ';
	}
}