<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) :

	wp_enqueue_style( 'wp-block-buttons' );
	wp_enqueue_style( 'wp-block-button' );

	$return_cls = 'wp-block-button__link has-secondary-background-color has-dark-color wc-backward';
	$return_url = apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) );
	$return_txt = apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) );
?>
<div class="wp-block-button has-text-align-center mt-5">
	<a class="<?php echo esc_attr( $return_cls ); ?>" href="<?php echo esc_url( $return_url ); ?>">
		<?php
			/**
			 * Filter "Return To Shop" text.
			 *
			 * @since 4.6.0
			 * @param string $default_text Default text.
			 */
			echo esc_html( $return_txt );
		?>
	</a>
</div>
<?php endif; ?>
