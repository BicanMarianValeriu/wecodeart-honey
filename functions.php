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
define( 'CHILD_THEME_NS',       'WeCodeArt\Doc' );
define( 'CHILD_THEME_INC', 	    __DIR__ . '/inc' );

// Start the engine
require_once( get_parent_theme_file_path( '/inc/init.php' ) );
new WeCodeArt\Autoloader( CHILD_THEME_NS, CHILD_THEME_INC ); 

// Load Skin DEPS
WeCodeArt\Doc\Scripts   ::get_instance(); // Assets
