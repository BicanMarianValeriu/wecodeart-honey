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

/**
 * Support
 */
class Support {

	use \WeCodeArt\Singleton;

	/**
	 * Send Construtor
	 */
	public function init() {
		register_block_style( 'core/list', [
			'name'	=> 'check',
            'label'	=> __( 'Check', 'wecodeart-honey' ),
		] );

		register_block_style( 'core/media-text', [
			'name'	=> 'overlap',
            'label'	=> __( 'Overlap', 'wecodeart-honey' ),
		] );
	}

	/**
	 * Render
	 *
	 * @since	1.0
	 * @version	1.0
	 *
	 * @return 	string
	 */
	public function render( $html, $args ) {}
}