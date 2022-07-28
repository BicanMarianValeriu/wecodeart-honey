<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$classes = ['wp-block-button__link', 'has-dark-color', 'has-secondary-background-color', 'alt', 'wc-forward', 'w-100' ];
?>
<div class="wp-block-button has-text-align-lg-right">
	<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="<?php echo esc_attr( join( ' ', $classes ) ); ?>">
		<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
	</a>
</div>
