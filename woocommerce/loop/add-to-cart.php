<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */
use function WeCodeArt\Functions\get_prop;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

wecodeart( 'styles' )->Utilities->load( [ 'w-100' ] );

$classes = [ 'wp-block-button__link', 'has-secondary-background-color', 'has-dark-color', 'w-100' ];

if( $_classes = get_prop( $args, [ 'class' ], '' ) ) {
	$classes = array_merge( $classes, explode( ' ', $_classes ) );
}

$classes = array_filter( $classes, function( $item ) {
	return $item !== 'button';
} );

?>
<div class="wp-block-button">
<?php
	
	echo apply_filters(
		'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
		sprintf(
			'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( get_prop( $args, [ 'quantity' ], 1 ) ),
			esc_attr( implode( ' ', $classes ) ),
			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			esc_html( $product->add_to_cart_text() )
		),
		$product,
		$args
	);

?>	
</div>
<?php

