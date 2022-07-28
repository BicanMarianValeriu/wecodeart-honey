<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

wecodeart( 'styles' )->Utilities->load( [
	'w-100',
	'my-5',
	'mt-0',
	'mt-3',
	'mb-3',
	'ms-1',
	'p-1',
	'd-block',
] );

wp_enqueue_style( 'wp-block-separator' );

?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<?php if ( $checkout->get_checkout_fields() ) : ?>
		<div class="grid my-5" style="--wp--columns:5;">
			<div class="span-5 span-lg-3" id="customer_details">
				<div class="accordion">
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<div class="accordion-item">
						<h2 class="accordion-header" id="customer-headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<?php esc_html_e( 'Customer Details', 'woocommerce' ); ?>
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="customer-headingOne">
							<div class="accordion-body">
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="customer-headingTwo">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
								<?php esc_html_e( 'Shipping Details', 'woocommerce' ); ?>
							</button>
						</h2>
						<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="customer-headingTwo">
							<div class="accordion-body">
							  	<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						</div>
					</div>
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				</div>
			</div>
			<div class="span-5 span-lg-2" id="order_review">
				<div class="card card-body">
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
					<div class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>
					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
