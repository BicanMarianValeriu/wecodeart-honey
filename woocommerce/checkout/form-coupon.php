<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

$message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon? Click here to enter your code.', 'woocommerce' ) );

?>
<div class="woocommerce-form-coupon-toggle accordion mb-3">
	<div class="accordion-item">
		<div class="accordion-header" id="couponHeading">
			<button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#couponForm" role="button" aria-expanded="false" aria-controls="couponForm"><?php
			
				echo wp_kses_post( $message );
				
			?></button>
		</div>
		<div class="accordion-collapse collapse" id="couponForm" aria-labelledby="couponHeading">
			<form class="accordion-body d-block checkout_coupon woocommerce-form-coupon needs-validation" method="post" novalidate="novalidate">
				<div class="woocommerce-form-coupon__field mb-3"><?php
				
					wecodeart_input( 'text', [
						'label' => esc_html__( 'If you have a coupon code, please apply it below.', 'woocommerce' ),
						'attrs' => [
							'name' 			=> 'coupon_code',
							'id' 			=> 'coupon_code',
							'placeholder'	=> esc_attr__( 'Coupon code', 'woocommerce' ),
							'value' 		=> '',
							'required'		=> true
						]
					] );
	
				?></div>
				<div class="woocommerce-form-coupon__field wp-block-button"><?php
				
					wecodeart_input( 'button', [
						'label' => esc_html__( 'Apply coupon', 'woocommerce' ),
						'attrs' => [
							'class'			=> 'wp-block-button__link has-primary-background-color',
							'name' 			=> 'apply_coupon',
							'type'			=> 'submit',
							'placeholder'	=> esc_attr__( 'Coupon code', 'woocommerce' ),
						]
					] );
	
				?></div>
			</form>
		</div>
	</div>
</div>
