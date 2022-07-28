<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

use function WeCodeArt\Functions\get_prop;

?>
<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
<div class="woocommerce-shipping-fields">
	<div class="mb-3" id="ship-to-different-address">
		<?php
		
		wecodeart_input( 'toggle', [
			'type'	=> 'checkbox',
			'label' => esc_html__( 'Ship to a different address?', 'woocommerce' ),
			'attrs' => [
				'id'	=> 'ship-to-different-address-checkbox',
				'name'	=> 'ship_to_different_address',
				'class'	=> 'form-switch',
				'value'	=> '1',
				'checked'	=> checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ) ),
			]
		] );

		?>
	</div>
	<div class="shipping_address">

		<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

		<div class="woocommerce-shipping-fields__field-wrapper grid mb-3" style="--wp--columns:2;">
			<?php
			$fields = $checkout->get_checkout_fields( 'shipping' );

			foreach ( $fields as $key => $field ) {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
			?>
		</div>

		<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

	</div>
</div>
<?php endif; ?>
<div class="woocommerce-additional-fields">

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

		<p class="mt-0"><strong><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></strong></p>

		<?php else : ?>
		
		<hr class="wp-block-separator is-style-wide has-light-color">

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) :
				wecodeart_input( get_prop( $field, 'type', 'hidden' ), [
					'label' => get_prop( $field, 'label' ),
					'attrs' => [
						'name' 			=> $key,
						'value'			=> $checkout->get_value( $key ),
						'class' 		=> join( ' ', wp_parse_args( [ 'form-control' ], get_prop( $field, 'class' ) ) ),
						'autocomplete' 	=> get_prop( $field, 'autocomplete' ),
						'required' 		=> get_prop( $field, 'required' ),
					]
				] );
			endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
