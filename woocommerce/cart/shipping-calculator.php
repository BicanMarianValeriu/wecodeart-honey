<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php printf( '<a href="#" class="shipping-calculator-button">%s</a>', esc_html( ! empty( $button_text ) ? $button_text : __( 'Calculate shipping', 'woocommerce' ) ) ); ?>

	<section class="shipping-calculator-form" style="display:none;">

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_country', true ) ) : ?>
		<p class="form-row form-row-wide" id="calc_shipping_country_field">
			<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
				<option value="default"><?php esc_html_e( 'Select a country / region&hellip;', 'woocommerce' ); ?></option>
				<?php
				foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				}
				?>
			</select>
		</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
		<p class="form-row form-row-wide" id="calc_shipping_state_field">
			<?php
			$current_cc = WC()->customer->get_shipping_country();
			$current_r  = WC()->customer->get_shipping_state();
			$states     = WC()->countries->get_states( $current_cc );

			if ( is_array( $states ) && empty( $states ) ) {

				wecodeart_input( 'hidden', [
					'attrs' => [
						'id' 			=> 'calc_shipping_state',
						'name' 			=> 'calc_shipping_state',
						'placeholder'	=> esc_attr__( 'State / County', 'woocommerce' ),
					]
				] );

			} elseif ( is_array( $states ) ) {
				?>
				<span>
					<select name="calc_shipping_state" class="state_select" id="calc_shipping_state" data-placeholder="<?php esc_attr_e( 'State / County', 'woocommerce' ); ?>">
						<option value=""><?php esc_html_e( 'Select an option&hellip;', 'woocommerce' ); ?></option>
						<?php
						foreach ( $states as $ckey => $cvalue ) {
							echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
						}
						?>
					</select>
				</span>
				<?php
			} else {

				wecodeart_input( 'text', [
					'attrs' => [
						'id' 			=> 'calc_shipping_state',
						'name' 			=> 'calc_shipping_state',
						'value'			=> $current_r,
						'placeholder'	=> esc_attr__( 'State / County', 'woocommerce' ),
					]
				] );
				
			}
			?>
		</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', true ) ) : ?>
		<p class="form-row form-row-wide" id="calc_shipping_city_field"><?php
			
			wecodeart_input( 'text', [
				'attrs' => [
					'id' 			=> 'calc_shipping_city',
					'name' 			=> 'calc_shipping_city',
					'value'			=> WC()->customer->get_shipping_city(),
					'placeholder'	=> esc_attr__( 'City', 'woocommerce' ),
				]
			] );
			
		?></p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
		<p class="form-row form-row-wide" id="calc_shipping_postcode_field"><?php
			
			wecodeart_input( 'text', [
				'attrs' => [
					'id' 			=> 'calc_shipping_postcode',
					'name' 			=> 'calc_shipping_postcode',
					'value'			=> WC()->customer->get_shipping_postcode(),
					'placeholder'	=> esc_attr__( 'Postcode / ZIP', 'woocommerce' ),
				]
			] );
			
		?></p>
		<?php endif; ?>

		<p class="form-row form-row-wide wp-block-button is-style-outline"><?php
		
			wecodeart_input( 'button', [
				'label'	=> esc_html__( 'Update', 'woocommerce' ),
				'attrs' => [
					'class'			=> 'wp-block-button__link has-dark-color has-small-font-size py-1',
					'type' 			=> 'submit',
					'name' 			=> 'calc_shipping',
					'value'			=> '1',
					'placeholder'	=> __( 'Postcode / ZIP', 'woocommerce' ),
				]
			] );

		?></p>

		<?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
