<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
<div class="woocommerce-billing-fields">
	<p class="mt-0"><strong><?php
	if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) :
		esc_html_e( 'Billing &amp; Shipping', 'woocommerce' );
		else : esc_html_e( 'Billing details', 'woocommerce' );
	endif;
	?></strong></p>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper grid" style="--wp--columns:2;">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<hr class="wp-block-separator is-style-wide has-light-color">
		<?php if ( ! $checkout->is_registration_required() ) : ?>
		<p class="form-row form-row-wide create-account">
			<?php
			
			wecodeart_input( 'toggle', [
				'type'	=> 'checkbox',
				'label' => esc_html__( 'Create an account?', 'woocommerce' ),
				'attrs' => [
					'id'	=> 'createaccount',
					'name'	=> 'createaccount',
					'class'	=> 'form-switch',
					'value'	=> '1',
					'checked'	=> checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ) ),
				]
			] );

			?>
		</p>
		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
		<div class="create-account mt-3">
		<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) :
			
			wecodeart_input( 'floating', [
				'type'	=> get_prop( $field, 'type', 'text' ),
				'label' => get_prop( $field, 'label' ),
				'attrs' => [
					'id'	=> $key,
					'class'	=> 'form-control mb-3',
					'name'	=> get_prop( $field, 'name' ),
					'required'		=> get_prop( $field, 'required' ),
					'placeholder' 	=> get_prop( $field, 'placeholder' ),
					'autocomplete'	=> get_prop( $field, 'autocomplete' ),
					'value'			=> $checkout->get_value( $key )
				]
			] );

		endforeach; ?>
		</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>
