<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<li class="accordion-item wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	<div class="accordion-header has-light-background-color p-1">	
	<?php
	
		wecodeart_input( 'radio', [
			'_label' 	=> 'after',
			'label' 	=> sprintf( '<strong class="ms-1 has-black-color">%s</strong>', $gateway->get_title() . $gateway->get_icon() ),
			'attrs' 	=> [
				'class'		=> 'form-check-input input-radio',
				'name'		=> 'payment_method',
				'id' 		=> 'payment_method_' . $gateway->id,
				'value'		=> $gateway->id,
				'checked'	=> $gateway->chosen ? 'checked' : false,
				'data-order_button_text' => $gateway->order_button_text,
			]
		] );
	
	?>
	</div>
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
	<div class="accordion-body has-black-color payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>"
		<?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>
		style="display:none;"
		<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
		<?php $gateway->payment_fields(); ?>
	</div>
	<?php endif; ?>
</li>
