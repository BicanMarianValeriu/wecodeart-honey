<?php
/**
 * WeCodeArt Honey 
 *
 * @package     WeCodeArt Honey 
 * @subpackage 	Scripts
 * @copyright   Copyright (c) 2023, WeCodeArt Honey
 * @link        https://www.wecodeart.com/
 * @since       1.0.0 
 * 
 */

namespace WeCodeArt\Honey;

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 	'WeCodeArt Honey' );
define( 'CHILD_THEME_URL', 		'https://www.wecodeart.com/' );
define( 'CHILD_THEME_VERSION', 	'1.0.0' ); 
define( 'CHILD_THEME_NS',       'WeCodeArt\Honey' );
define( 'CHILD_THEME_INC', 	    __DIR__ . '/inc' );

// Start the engine
require_once( get_parent_theme_file_path( '/inc/init.php' ) );
new \WeCodeArt\Autoloader( CHILD_THEME_NS, CHILD_THEME_INC );

// Load Skin DEPS
Scripts::get_instance(); // Assets

// Block Styles
\register_block_style( 'core/list', [
    'name'	=> 'check',
    'label'	=> esc_html__( 'Check', 'wecodeart-honey' ),
] );

\register_block_style( 'core/media-text', [
    'name'	=> 'overlap',
    'label'	=> esc_html__( 'Overlap', 'wecodeart-honey' ),
] );

\register_block_style( 'core/cover', [
    'name'	=> 'top',
    'label'	=> esc_html__( 'Top', 'wecodeart-honey' ),
] );

// Maskot
\add_shortcode( 'wecodeart-decoration', __NAMESPACE__ . '\\maskot' );
function maskot() {
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
// \add_filter( 'woocommerce_states', __NAMESPACE__ . '\\filter_states', 20, 1 );
function filter_states( $states ) {
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
// \add_filter( 'default_checkout_billing_state', __NAMESPACE__ . '\\filter_default_state' );
function filter_default_state() {
    return 'GJ';
}