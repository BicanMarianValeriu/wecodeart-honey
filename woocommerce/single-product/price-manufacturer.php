<?php
/**
 * Single Product Manufacturer Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price-manufacturer.php.
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

if( ! isset( $product ) ) {
	global $product;
}

$prp = $product->get_meta( 'price_manufacturer' );

if( empty( $prp ) ) {
	return '';
}

$message = esc_html__( 'Acesta este prețul recomandat de producător. Prețul de vânzare al produsului este afișat mai jos.', 'wecodeart-honey' );

wecodeart( 'styles' )->Utilities->load( [
	'ms-1',
	'm-0',
] );

wecodeart( 'markup' )->SVG::add( 'info', [
	'viewBox'	=> '0 0 16 16',
	'paths' 	=> [
		'M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z',
		'm8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'
	]
] );

?>
<p class="woocommerce-product-prp has-small-font-size has-cyan-bluish-gray-color m-0">
	<span><?php
	
		printf( 'PRP: %s', wc_price( $prp ) );

	?></span>
	<a class="has-cyan-bluish-gray-color ms-1"
		href="javascript:void(0);"
		data-bs-toggle="tooltip"
		data-bs-custom-class="prp-tooltip"
		title="<?php echo esc_attr( $message ); ?>">
		<?php
		
		wecodeart( 'markup' )->SVG::render( 'info', [
			'class' => 'fa-fw'
		] );

		?>
	</a>
</p>
