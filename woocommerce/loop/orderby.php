<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wecodeart( 'styles' )->Utilities->load( [ 'rounded-pill', 'float-end' ] );

?>
	<div class="span-2 span-sm-1">
		<form class="woocommerce-ordering float-end" method="get">
			<?php
			
			wecodeart_input( 'select', [
				'choices' 	=> $catalog_orderby_options,
				'attrs' 	=> [
					'id'			=> false,
					'name'			=> 'orderby',
					'class' 		=> 'orderby form-select rounded-pill',
					'aria-label' 	=> __( 'Shop order', 'woocommerce' ),
					'value'			=> $orderby,
				],
			] );
			
			?>
			<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, [ 'orderby', 'submit', 'paged', 'product-page' ] ); ?>
		</form>
	</div>
</div>
