<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

wecodeart( 'styles' )->Utilities->load( [ 'd-flex', 'flex-column' ] );

$product_meta = [
	'sku' 	=> [
		'label'		=> esc_html__( 'SKU:', 'woocommerce' ),
		'value'		=> ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ),
		'condition' => function() use( $product ) {
			return ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) );
		}
	],
	'cat' 	=> [
		'label'		=> wecodeart( 'markup' )->SVG::compile( count( $product->get_category_ids() ) > 1 ? 'folders' : 'folder', [
			'class' => 'fa-fw has-dark-color'
		] ),
		'value'		=> wc_get_product_category_list( $product->get_id(), ', ' ),
	],
	'tag' 	=> [
		'label'		=> wecodeart( 'markup' )->SVG::compile( 'tags', [
			'class' => 'fa-fw has-dark-color'
		] ),
		'value'		=> wc_get_product_tag_list( $product->get_id(), ', ' ),
	]
];

?>
<div class="woocommerce-product-meta vstack">

	<?php 
	
	do_action( 'woocommerce_product_meta_start' );

	foreach( $product_meta as $key => $meta ) :
		$condition = isset( $meta['condition' ] ) && is_callable( $meta['condition'] ) ? call_user_func( $meta['condition'] ) : true;
		
		if( ! $condition ) continue;
		
	?>
	<span class="product-meta__item product-meta__item--<?php echo esc_attr( $key ); ?>">
	<?php if( isset( $meta['label'] ) ) echo $meta['label']; ?>
	<?php echo $meta['value']; ?>
	</span>
	<?php
	endforeach;
	
	do_action( 'woocommerce_product_meta_end' );
	
	?>

</div>
