<?php
/**
 * WeCodeArt Honey 
 *
 * @package     WeCodeArt Honey 
 * @subpackage 	Scripts
 * @copyright   Copyright (c) 2021, WeCodeArt Honey
 * @link        https://www.wecodeart.com/
 * @since       1.0.0 
 * 
 */

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 	'WeCodeArt Honey' );
define( 'CHILD_THEME_URL', 		'https://www.wecodeart.com/' );
define( 'CHILD_THEME_VERSION', 	'1.0.0' ); 
define( 'CHILD_THEME_NS',       'WeCodeArt\Honey' );
define( 'CHILD_THEME_INC', 	    __DIR__ . '/inc' );

// Start the engine
require_once( get_parent_theme_file_path( '/inc/init.php' ) );
new WeCodeArt\Autoloader( CHILD_THEME_NS, CHILD_THEME_INC );

// Load Skin DEPS
WeCodeArt\Honey\Scripts   ::get_instance(); // Assets
WeCodeArt\Honey\Support   ::get_instance(); // Support
WeCodeArt\Honey\Widgets   ::get_instance(); // Widgets
		
add_action( 'litespeed_esi_load-woo_mini_cart', function( $params ) {
    do_action( 'litespeed_control_set_nocache' );

    echo $params['content'];
} );
